<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'laporan' => 'required|string',
            'gambar'  => 'nullable|image|max:2048', // 2MB max
        ];
    }

    public function messages(): array
    {
        return [
            'laporan.required' => __('request_laporan.validation.laporan.required'),
            'laporan.string'   => __('request_laporan.validation.laporan.string'),
            'gambar.image'     => __('request_laporan.validation.gambar.image'),
            'gambar.max'       => __('request_laporan.validation.gambar.max'),
        ];
    }
}
