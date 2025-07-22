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
            'order_id.required'        => 'Order harus dipilih.',
            'order_id.exists'          => 'Order tidak valid.',
            'user_id.required'         => 'User harus dipilih.',
            'user_id.exists'           => 'User tidak valid.',
            'notes.required'           => 'Catatan wajib diisi.',
            'notes.string'             => 'Catatan harus berupa teks.',
            'approval_status.required' => 'Status persetujuan wajib diisi.',
            'approval_status.in'       => 'Status persetujuan harus 0 (ditolak), 1 (disetujui), atau 2 (revisi).',
        ];
    }
}