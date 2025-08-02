<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenugasanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,order_id',
            'user_id'  => 'required|exists:users,user_id',
            'status'   => 'nullable|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required' => __('request_penugasan.validation.order_id.required'),
            'order_id.exists'   => __('request_penugasan.validation.order_id.exists'),
            'user_id.required'  => __('request_penugasan.validation.user_id.required'),
            'user_id.exists'    => __('request_penugasan.validation.user_id.exists'),
            'status.in'         => __('request_penugasan.validation.status.in'),
        ];
    }
}
