<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
        return [
            'job_title' => ['required'],
            'job_type' => ['required'],
            'qualification' => ['required'],
            'job_category' => ['required'],
            'job_role' => ['required'],
            'job_industry' => ['required'],
            'vacancies' => ['required'],
            'experience' => ['required'],
            'salary_type' => ['required'],
            'deadline' => ['required'],
            'job_desc' => ['required'],
            'location' => ['required'],
            'country' => $this->location == 'other_location' ? 'required' : 'nullable',
            'state' => $this->location == 'other_location' ? 'required' : 'nullable',
            'city' => $this->location == 'other_location' ? 'required' : 'nullable',
        ];
    }
}
