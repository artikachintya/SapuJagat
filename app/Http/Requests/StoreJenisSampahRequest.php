<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisSampahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'photos'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'type'         => 'required|string|max:255',
            'price_per_kg' => 'required|numeric',
            'max_weight'   => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Nama sampah wajib diisi.',
            'name.string'           => 'Nama sampah harus berupa teks.',
            'name.max'              => 'Nama sampah maksimal 255 karakter.',

            'photos.required'       => 'Foto sampah wajib diunggah.',
            'photos.image'          => 'File harus berupa gambar.',
            'photos.mimes'          => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'photos.max'            => 'Ukuran gambar maksimal 2MB.',

            'type.required'         => 'Jenis sampah wajib diisi.',
            'type.string'           => 'Jenis sampah harus berupa teks.',
            'type.max'              => 'Jenis sampah maksimal 255 karakter.',

            'price_per_kg.required' => 'Harga per kg wajib diisi.',
            'price_per_kg.numeric'  => 'Harga per kg harus berupa angka.',

            'max_weight.required'   => 'Berat maksimal wajib diisi.',
            'max_weight.numeric'    => 'Berat maksimal harus berupa angka.',
        ];
    }
}