<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentWebhookRequest extends FormRequest
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
        return [
            'internal_reference' => ['required'],
            'customer_reference' => ['required'],
            'msisdn' => ['required'],
            'status' => ['required'],
            'provider' => ['required'],
            'charge' => ['required|numeric'],
        ];
    }
}
