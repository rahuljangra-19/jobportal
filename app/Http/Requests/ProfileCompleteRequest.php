<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileCompleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'phone' => 'required',
            'image' => 'required|image|mimes:jpeg,png|max:2048',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ];

        if (Auth::user()->role === 'employee') {
            $rules['exp'] = 'required';
            $rules['skills'] = 'required';
            $rules['resume'] = 'required|mimes:pdf|max:2048';
            $rules['industry'] = 'required';
            $rules['profile'] = 'required';
            $rules['qualification'] = 'required';
            if (Auth::user()->loginType == 2) {
                $rules['password'] = 'required|min:6';
            }
            if (Auth::user()->loginType == 2 && empty(Auth::user()->email)) {
                $rules['email'] = 'required|email|unique:users,email';
            }
        }

        return $rules;
    }
}
