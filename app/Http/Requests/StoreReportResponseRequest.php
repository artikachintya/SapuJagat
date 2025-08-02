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
            'report_id.required'        => __('request_report.validation.report_id.required'),
            'report_id.exists'          => __('request_report.validation.report_id.exists'),
            'user_id.required'          => __('request_report.validation.user_id.required'),
            'user_id.exists'            => __('request_report.validation.user_id.exists'),
            'response_message.required' => __('request_report.validation.response_message.required'),
            'response_message.string'   => __('request_report.validation.response_message.string'),
            'response_message.max'      => __('request_report.validation.response_message.max'),
        ];
    }
}
