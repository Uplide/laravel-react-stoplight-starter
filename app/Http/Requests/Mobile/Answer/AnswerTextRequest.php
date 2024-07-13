<?php

namespace App\Http\Requests\Mobile\Answer;

use Illuminate\Foundation\Http\FormRequest;

class AnswerTextRequest extends FormRequest
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
             * Bu alan sorunun ID'si ni temsil eder.
             * @var integer
             * @example 1
             */
            'id' => [
                'required',
                'integer',
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
