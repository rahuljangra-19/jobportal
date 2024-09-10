<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JobController;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{ 
    #--- load index blade file ---#
    public function index(Request $request)
    {
        if (!Auth::check() || (auth()->check() && (auth()->user()->role == 'employee' || auth()->user()->role == 'company'))) {
            $jobs       = new JobController();
            $data       = $jobs->getJobs($request, 4);
            if (Gate::allows('company')) {
                $data   = $jobs->getEmp($request, 6);
                return view('front.pages.index', ['data' => $data]);
            }
            return view('front.pages.index', ['jobs' => $data]);
        }
        if (Gate::allows('admin')) {
            return redirect()->route('admin.dashboard');
        }
    }

    #---- load login blade file ----#
    public function login(Request $request)
    {
        return view('front.auth.login');
    }


    #--- login ---#
    public function checkAuth(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => ['company', 'employee']], $request->remember)) {
                if (Auth::user()->is_profile_completed) {
                    return redirect()->route('index');
                } else {
                    return redirect()->route('profile');
                }
            }
            return Redirect::back()->with(['error' => 'Credentials not matched.']);
        } catch (Exception $e) {
            abort(400);
        }
    }


    #--- logout --#
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    #--- get Countries ---#
    public function getCountries(Request $request)
    {
        $search     = $request->input('search');
        $countries  = Country::select('id', 'name as text')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->limit(25)->get();

        return response()->json($countries);
    }

    public function getStates(Request $request)
    {
        $search     = $request->input('search');
        $countryId  = $request->input('country_id');

        $states = State::select('id', 'name as text')
            ->where('country_id', $countryId)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->limit(25)->get();

        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $search     = $request->input('search');
        $stateId    = $request->input('state_id');

        $cities     = City::select('id', 'name as text')
            ->where('state_id', $stateId)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->limit(25)->get();

        return response()->json($cities);
    }


    #-- forgotPassword ---#
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status), 'success' => 'We have e-mailed your password reset link!'])
            : back()->withErrors(['email' => __($status)]);
    }

    #--- resetPassword ----#
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with(['status' => __($status), 'success' => 'Password updated successfully'])
            : back()->withErrors(['email' => [__($status)]]);
    }
}
