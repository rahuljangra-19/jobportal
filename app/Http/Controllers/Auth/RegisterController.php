<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #-- load register blade file ---#
    public function index(Request $request)
    {
        return view('front.auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules($request->input('role')));
        try {
            $user                = new User();
            $user->token         = Str::random(15);
            $user->first_name    = $request->first_name;
            $user->last_name     = $request->last_name;
            $user->user_name     = $request->user_name;
            $user->role          = $request->role;
            $user->email         = $request->email;
            $user->password      = Hash::make($request->password);
            $user->company_name  = $request->company_name;
            $user->company_type  = $request->company_type;
            $user->save();

            Auth::login($user);
            return redirect()->route('profile')->with('success', 'Registration successful');
        } catch (Exception $e) {
            dd($e->getMessage());
            abort(400);
        }
    }

    protected function validationRules($role)
    {
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'user_name' => 'required|string|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
        ];

        if ($role === 'company') {
            $rules['company_name'] = 'required|string';
            $rules['company_type'] = 'required|string';
        }

        return $rules;
    }
}
