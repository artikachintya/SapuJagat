<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

       public function rules(): array
    {
         $userId = $this->user()->id;
         $user= $this->user(); 
         $currentEmail = $this->user()->email;
        $currentPhone = $this->user()->phone_num;

        $rules = [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|digits_between:4,6',

        ];


                    if ($this->email !== $currentEmail) {
                $rules['email'] = [
                    'required',
                    'email:dns',
                    Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')
                ];
            } else {
                $rules['email'] = 'required|email:dns';
            }

              if ($user->is_google_user && empty($user->NIK)) {
        $rules['NIK'] = 'required|digits:16|unique:users,nik';
    }



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
            'email.required' => __('request_register.validation.email.required'),
            'email.email' => __('request_register.validation.email.email'),
            'email.unique' => __('request_register.validation.email.unique'),
            'password.required' => __('request_register.validation.password.required'),
            'password.min' => __('request_register.validation.password.min'),
            'password.regex' => __('request_register.validation.password.regex'),
            'address.required' => __('request_register.validation.address.required'),
            'address.max' => __('request_register.validation.address.max'),
            'province.required' => __('request_register.validation.province.required'),
            'province.max' => __('request_register.validation.province.max'),
            'city.required' => __('request_register.validation.city.required'),
            'city.max' => __('request_register.validation.city.max'),
            'postal_code.required' => __('request_register.validation.postal_code.required'),
            'postal_code.digits_between' => __('request_register.validation.postal_code.digits_between'),
            'NIK.required' => __('request_register.validation.NIK.required'),
            'NIK.digits' => __('request_register.validation.NIK.digits'),
            'NIK.unique' => __('request_register.validation.NIK.unique'),
            'phone_num.required' => __('request_register.validation.phone_num.required'),
            'phone_num.digits_between' => __('request_register.validation.phone_num.digits_between'),
            'phone_num.unique' => __('request_register.validation.phone_num.unique'),
        ];
    }
}
