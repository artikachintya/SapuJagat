<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersetujuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id'        => 'required|exists:orders,order_id',
            'user_id'         => 'required|exists:users,user_id',
            'notes'           => 'required|string',
            'approval_status' => 'required|in:0,1,2',
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.required'        => __('request_persetujuan.validation.order_id.required'),
            'order_id.exists'          => __('request_persetujuan.validation.order_id.exists'),
            'user_id.required'         => __('request_persetujuan.validation.user_id.required'),
            'user_id.exists'           => __('request_persetujuan.validation.user_id.exists'),
            'notes.required'           => __('request_persetujuan.validation.notes.required'),
            'notes.string'             => __('request_persetujuan.validation.notes.string'),
            'approval_status.required' => __('request_persetujuan.validation.approval_status.required'),
            'approval_status.in'       => __('request_persetujuan.validation.approval_status.in'),
        ];
    }
}
