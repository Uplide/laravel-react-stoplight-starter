<?php

namespace App\Http\Requests\Mobile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterEmailVerifyResendRequest extends FormRequest
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
             * Bu alan kullanıcı e-posta adresidir.
             * @var string
             * @example kesmenere123@gmail.com
             */
            'email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if (!$user->email) {
                        $fail('Sisteme kayıt yapılmamış. Lüften sisteme kayıt işlemi yapınız!');
                    }

                    if ($user->is_email_verify) {
                        $fail('E-posta kodu doğrulanmış yeniden doğrulama işlemi yapamazsınız!');
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
            'email.required' => 'Giriş bilgisi gereklidir.',
            'email.string' => 'Giriş bilgisi metin olmalıdır.',
            'email.email' => 'Giriş bilgisi e-posta formatında olmalıdır.',
        ];
    }
}
