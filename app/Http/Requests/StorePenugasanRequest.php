<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenugasanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow access, handle auth with middleware
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
            'order_id.required' => 'Order wajib dipilih.',
            'order_id.exists'   => 'Order tidak ditemukan.',
            'user_id.required'  => 'User wajib dipilih.',
            'user_id.exists'    => 'User tidak ditemukan.',
            'status.in'         => 'Status harus bernilai 0 atau 1.',
        ];
    }
}