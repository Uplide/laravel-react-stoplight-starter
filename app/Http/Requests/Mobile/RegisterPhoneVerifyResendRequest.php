<?php

namespace App\Http\Requests\Mobile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterPhoneVerifyResendRequest extends FormRequest
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
    public function rules()
    {
        return [
            /**
             * Bu alan kullanıcı telefonudur.
             * @var string
             * @example 905419322605
             */
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $user = User::where('phone', $value)->first();
                    if (!$user->phone) {
                        $fail('Sisteme kayıt yapılmamış. Lüften sisteme kayıt işlemi yapınız!');
                    }

                    if ($user->is_phone_verify) {
                        $fail('Telefon kodu doğrulanmış yeniden doğrulama işlemi yapamazsınız!');
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
    public function messages()
    {
        return [
            'phone.required' => 'Telefon numarası gereklidir.',
            'phone.string' => 'Telefon numarası metin olmalıdır.',
        ];
    }
}
