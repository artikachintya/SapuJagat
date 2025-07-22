<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_id'        => 'required|exists:reports,report_id',
            'user_id'          => 'required|exists:users,user_id',
            'response_message' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'report_id.required'        => 'Laporan wajib dipilih.',
            'report_id.exists'          => 'Laporan tidak ditemukan.',
            'user_id.required'          => 'User wajib dipilih.',
            'user_id.exists'            => 'User tidak valid.',
            'response_message.required' => 'Pesan tanggapan wajib diisi.',
            'response_message.string'   => 'Pesan harus berupa teks.',
            'response_message.max'      => 'Pesan maksimal 255 karakter.',
        ];
    }
}