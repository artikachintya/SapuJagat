<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserStatusRequest extends FormRequest
{
    public function authorize()
    {
        // Change to true to allow all users or add your own logic
        return true;
    }

    public function rules()
    {
        return [
            'status' => 'required|in:0,1',
        ];
    }
}