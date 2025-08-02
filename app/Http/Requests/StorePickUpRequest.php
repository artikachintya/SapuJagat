<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePickUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'status' => 'required|in:start_jemput,pick_up,arrival',
        ];

        if ($this->input('status') === 'arrival') {
            $rules['photo'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            $rules['notes'] = 'required|string|min:1';
        }

        return $rules;
    }

     public function messages()
    {
        return [
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status tidak valid',
            'photo.required' => 'Foto bukti wajib diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
            'notes.required' => 'Catatan pengantaran wajib diisi',
        ];
    }
}
