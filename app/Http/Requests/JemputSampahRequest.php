<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JemputSampahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ubah jika perlu autentikasi spesifik
    }

    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    //  */
    public function rules(): array
    {
        return [
            'pickup_time' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'photo.required' => 'Silakan unggah bukti pesanan terlebih dahulu.',
            'photo.image' => 'Bukti pesanan harus berupa gambar.',
            'photo.mimes' => 'Format gambar tidak valid. Harus berupa file dengan format jpeg, jpg, atau png.',
            'photo.max' => 'Ukuran gambar terlalu besar. Maksimum 5MB.',
        ];
    }
}
