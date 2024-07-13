<?php

namespace App\Http\Requests\Mobile\Answer;

use Illuminate\Foundation\Http\FormRequest;

class AnswerVoiceTextRequest extends FormRequest
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
            /**
             * Bu alan sorunun ID'sini temsil eder.
             * @var integer
             * @example 1
             */
            'id' => [
                'required',
                'integer',
            ],

            /**
             * Bu alan sorunun cevabının ses dosyasını temsil eder. [mimes:mp3,wav,ogg]
             * @type file
             */
            'voice' => [
                'required',
                'file',
                'mimes:mp3,wav,ogg',
                'max:10240', // Maksimum dosya boyutu 10MB
            ],

            /**
             * Bu alan sorunun cevabını temsil eder.
             * @var string
             * @example Merhaba...
             */
            'text_answer' => [
                'required',
                'string',
            ],
        ];
    }
}
