<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDriverProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;
        $currentPhone = $this->user()->phone_num;

        $rules = [
            'name' => 'required|string|max:255',
            'license_plate' => [
                'required',
                'regex:/^[A-Z]{1,2}[0-9]{1,4}[A-Z]{1,3}$/'
            ],
            'profile_pic' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];

        if ($this->phone_num !== $currentPhone) {
            $rules['phone_num'] = [
                'required',
                'digits_between:8,15',
                Rule::unique('users', 'phone_num')->ignore($userId)
            ];
        } else {
            $rules['phone_num'] = 'required|digits_between:8,15';
        }

        if ($this->filled('password')) {
            $rules['password'] = [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/'
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => __('request_register.validation.name.required'),
            'name.max' => __('request_register.validation.name.max'),
            'password.required' => __('request_register.validation.password.required'),
            'password.min' => __('request_register.validation.password.min'),
            'password.regex' => __('request_register.validation.password.regex'),
            'phone_num.required' => __('request_register.validation.phone_num.required'),
            'phone_num.digits_between' => __('request_register.validation.phone_num.digits_between'),
            'phone_num.unique' => __('request_register.validation.phone_num.unique'),
            'license_plate.required' =>  __('request_profile.validation.license_plate.required'),
            'license_plate.string' =>  __('request_profile.validation.license_plate.string'),
            'profile_pic.image' =>  __('request_profile.validation.profile_pic.image'),
            'profile_pic.mimes' =>  __('request_profile.validation.profile_pic.mimes'),
            'profile_pic.max' =>  __('request_profile.validation.profile_pic.max'),
            'license_plate.regex' =>  __('request_profile.validation.license_plate.regex'),
        ];
    }
}
