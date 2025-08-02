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
            'photo.required' => __('jemputsampah_user.photo_required'),
            'photo.image' => __('jemputsampah_user.photo_image'),
            'photo.mimes' => __('jemputsampah_user.photo_mimes'),
            'photo.max' => __('jemputsampah_user.photo_max'),
        ];
    }
}
