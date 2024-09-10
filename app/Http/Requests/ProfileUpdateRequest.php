<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'user_name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ];

        if (Auth::user()->role === 'employee') {
            $rules['exp'] = 'required';
            $rules['skills'] = 'required';
            $rules['industry'] = 'required';
            $rules['profile'] = 'required';
            $rules['qualification'] = 'required';
        }

        if (Auth::user()->role === 'company') {
            $rules['company_name'] = 'required';
            $rules['company_type'] = 'required';
        }

        return $rules;
    }
}
