<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserSocialDetails;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class socialLoginController extends Controller
{
    public function index($social)
    {
        if ($social === 'linkedin') {
            return Socialite::driver('linkedin-openid')->scopes(['openid', 'profile', 'email'])->redirect();
        }

        return Socialite::driver($social)->redirect();
    }

    public function store($provider)
    {
        $userSocial       =   Socialite::driver($provider)->stateless()->user();
        $user             =   User::where(['email' => $userSocial->getEmail()])->first();
        DB::beginTransaction();
        try {
            if ($user) {
                $socialDetails = UserSocialDetails::where(['user_id' => $user->id, 'provider' => $provider, 'provider_id' => $userSocial->getId()])->first();
                if (empty($socialDetails)) {
                    $userSocialDetails              = new UserSocialDetails();
                    $userSocialDetails->user_id     = $user->id;
                    $userSocialDetails->provider_id = $userSocial->getId();
                    $userSocialDetails->provider    = $provider;
                    $userSocialDetails->token       =  $userSocial->token;
                    $userSocialDetails->save();
                }
            } else {
                $userData =  $userSocial->user;

                $user                       = new User();
                $user->first_name           = isset($userData['given_name']) ? $userData['given_name'] : $userSocial->getName();
                $user->last_name            = isset($userData['family_name']) ? $userData['family_name'] : (isset($userData['given_name']) ? $userData['given_name'] : $userSocial->getName());
                $user->user_name            = $userSocial->getName();
                $user->password             = Hash::make(123456);
                $user->email                = $userSocial->getEmail();
                $user->role                 = 'employee';
                $user->token                = Str::random(15);
                $user->save();
                if ($user) {
                    $userSocialDetails               = new UserSocialDetails();
                    $userSocialDetails->user_id      = $user->id;
                    $userSocialDetails->provider_id  = $userSocial->getId();
                    $userSocialDetails->provider     = $provider;
                    $userSocialDetails->token        =  $userSocial->token;
                    $userSocialDetails->save();
                }
            }

            DB::commit();
            Auth::login($user);
            User::where('id', Auth::id())->update(['loginType' => 2]);

            if (Auth::user()->is_profile_completed) {
                return redirect()->route('index');
            } else {
                return redirect()->route('profile')->with('success', 'Login successfull');
            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->route('login')->with('error', 'Something went wrong');
        }
    }


    public function redirectToInstagram()
    {
        $clientId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));

        $url = "https://api.instagram.com/oauth/authorize?client_id={$clientId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code";

        return redirect()->away($url);
    }

    public function handleInstagramCallback(Request $request)
    {
        $code = $request->input('code');

        $clientId =  config('services.instagram.client_id');
        $clientSecret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');

        $client = new Client();

        $response = $client->post('https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        $accessToken = $data['access_token'];

        // Example using Guzzle HTTP client to fetch profile information
        $client = new Client();
        $response = $client->get('https://graph.instagram.com/me', [
            'query' => [
                'fields' => 'id,username,profile_picture_url',
                'access_token' => $accessToken,
            ],
        ]);

        $profileData = json_decode($response->getBody(), true);

        $name = str_replace(' ', '_', $profileData['username']);

        if ($profileData) {
            $socialDetails = UserSocialDetails::where(['provider' => 'instagram', 'provider_id' => $profileData['id']])->first();
            if (empty($socialDetails)) {
                $user                       = new User();
                $user->first_name           = $name;
                $user->last_name            = $name;
                $user->user_name            = $name;
                $user->role                 = 'employee';
                $user->password             = Hash::make(123456);
                $user->token                = Str::random(15);
                $user->save();

                if ($user) {
                    $userSocialDetails                  = new userSocialDetails();
                    $userSocialDetails->user_id         = $user->id;
                    $userSocialDetails->provider_id     = $profileData['id'];
                    $userSocialDetails->provider        = 'instagram';
                    $userSocialDetails->token           =  $accessToken;
                    $userSocialDetails->save();
                }
            } else {
                $socialDetails->token           =  $accessToken;
                $socialDetails->save();

                $user = User::find($socialDetails->user_id);
            }
            Auth::login($user);
            User::where('id', Auth::id())->update(['loginType' => 2]);


            if (Auth::user()->is_profile_completed) {
                return redirect()->route('index');
            } else {
                return redirect()->route('profile')->with('success', 'Login successfull');
            }
        }
        return redirect()->route('login')->with('error', 'Something went wrong');
    }
}
