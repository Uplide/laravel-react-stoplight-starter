<?php

namespace App\Http\Requests\Mobile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterEmailVerifyRequest extends FormRequest
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
             * Kimlik bilgisi e-postası.
             * @var string
             * @example kesemenere123@gmail.com
             */
            'email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) {
                    if (!User::where('email', $value)->exists()) {
                        $fail('Email adresiniz hatalı.');
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
            'email.required' => 'Giriş bilgisi gereklidir.',
            'email.string' => 'Giriş bilgisi metin olmalıdır.',
            'email.email' => 'Giriş bilgisi e-posta formatında olmalıdır.',
            'verify_code.required' => 'Doğrulama kodu gereklidir.',
            'verify_code.integer' => 'Doğrulama kodu sayı olmalıdır.',
        ];
    }
}
