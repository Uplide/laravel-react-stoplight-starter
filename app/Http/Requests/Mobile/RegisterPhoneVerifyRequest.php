<?php

namespace App\Http\Requests\Mobile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterPhoneVerifyRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            /**
             * Doğrulama kodu e-postası veya telefon ile gönderilen mesajı kodu.
             * @var integer
             * @example 9452
             */
            'verify_code' => [
                'required',
                'integer',
            ],
            /**
             * Kimlik bilgisi telefonu.
             * @var string
             * @example 905419322694
             */
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!User::where('phone', $value)->exists()) {
                        $fail('Telefon numaranız hatalı.');
                    }
                },
            ],

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'phone.required' => 'Giriş bilgisi gereklidir.',
            'phone.string' => 'Giriş bilgisi metin olmalıdır.',
            'verify_code.required' => 'Doğrulama kodu gereklidir.',
            'verify_code.integer' => 'Doğrulama kodu sayı olmalıdır.',
        ];
    }
}
