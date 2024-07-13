<?php

namespace App\Http\Requests\Mobile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
             * Bu alan kullanıcı e-postasıdır.
             * @var string
             * @example kesemenere123@gmail.com
             */
            'email' => [
                'required',
                'string',
                "email",
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->first()) {
                        $fail('E-posta adresi veya telefon numaranız kullanımda');
                    }
                },
            ],
            /**
             * Bu alan kullanıcı telefonudur.
             * @var string
             * @example 905419322605
             */
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (User::where('phone', $value)->first()) {
                        $fail('E-posta adresi veya telefon numaranız kullanımda');
                    }
                },
            ],
            /**
             * Bu alan kullanıcı telefonunun telefon kodudur. (+90)
             * @var string
             * @example +90
             */
            'phone_code' => [
                'required',
                'string',
            ],
            /**
             * Bu alan kullanıcının adıdır.
             * @var string
             * @example Feyyaz Can
             */
            'name' => [
                'required',
                'string',
            ],
            /**
             * Bu alan kullanıcının soyadıdır.
             * @var string
             * @example Köse
             */
            'surname' => [
                'required',
                'string',
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
            'email.required' => 'E-posta adresi gereklidir.',
            'email.string' => 'E-posta adresi metin olmalıdır.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'phone.required' => 'Telefon numarası gereklidir.',
            'phone.string' => 'Telefon numarası metin olmalıdır.',
            'name.required' => 'Ad gereklidir.',
            'name.string' => 'Ad metin olmalıdır.',
            'surname.required' => 'Soyad gereklidir.',
            'surname.string' => 'Soyad metin olmalıdır.',
            'birthday.required' => 'Doğum tarihi gereklidir.',
            'birthday.string' => 'Doğum tarihi date string formatonda olmalıdır.',
        ];
    }
}
