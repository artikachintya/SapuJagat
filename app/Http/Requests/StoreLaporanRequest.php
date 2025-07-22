<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLaporanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or apply authorization logic
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
            'laporan.required' => 'Isi laporan wajib diisi.',
            'laporan.string'   => 'Isi laporan harus berupa teks.',

            'gambar.image'     => 'File yang diunggah harus berupa gambar.',
            'gambar.max'       => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}