<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
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
             * Kullanıncının geri bildirim mesajı.
             * @var string
             * @example Merhaba...
             */
            'message' => [
                'required',
                'string',
            ],

            /**
             * Kullanıncının geri bildirimde işaretlediği star sayısı.
             * @var integer
             * @example 1
             */
            'star' => [
                'required',
                'integer',
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
            'message.required' => 'Mesaj gereklidir.',
            'message.string' => 'Mesaj metin olmalıdır.',
        ];
    }
}
