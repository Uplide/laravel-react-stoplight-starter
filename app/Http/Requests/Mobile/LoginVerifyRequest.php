<?php

namespace App\Http\Requests\Mobile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginVerifyRequest extends FormRequest
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
             * Kimlik bilgisi kullanıcısının e-postası veya telefonu.
             * @var string
             * @example kesemenere123@gmail.com
             */
            'credential' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !preg_match('/^\d{10,15}$/', $value)) {
                        $fail('Geçerli bir e-posta adresi veya telefon numarası giriniz.');
                    }

                    $userExists = filter_var($value, FILTER_VALIDATE_EMAIL)
                        ? User::where('email', $value)->exists()
                        : User::where('phone', $value)->exists();

                    if (!$userExists) {
                        $fail('Email adresi veya telefon numaranız hatalı.');
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
            'credential.required' => 'Giriş bilgisi gereklidir.',
            'credential.string' => 'Giriş bilgisi metin olmalıdır.',
            'verify_code.required' => 'Doğrulama kodu gereklidir.',
            'verify_code.integer' => 'Doğrulama kodu sayı olmalıdır.',
        ];
    }
}
