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
            'name.required'         => __('request_jenis_sampah.name.required'),
            'name.string'           => __('request_jenis_sampah.name.string'),
            'name.max'              => __('request_jenis_sampah.name.max'),

            'photos.required'       => __('request_jenis_sampah.photos.required'),
            'photos.image'          => __('request_jenis_sampah.photos.image'),
            'photos.mimes'          => __('request_jenis_sampah.photos.mimes'),
            'photos.max'            => __('request_jenis_sampah.photos.max'),

            'type.required'         => __('request_jenis_sampah.type.required'),
            'type.string'           => __('request_jenis_sampah.type.string'),
            'type.max'              => __('request_jenis_sampah.type.max'),

            'price_per_kg.required' => __('request_jenis_sampah.price_per_kg.required'),
            'price_per_kg.numeric'  => __('request_jenis_sampah.price_per_kg.numeric'),

            'max_weight.required'   => __('request_jenis_sampah.max_weight.required'),
            'max_weight.numeric'    => __('request_jenis_sampah.max_weight.numeric'),
        ];
    }
}
