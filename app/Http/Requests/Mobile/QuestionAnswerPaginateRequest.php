<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAnswerPaginateRequest extends FormRequest
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
             * Listelenmesi istenilen sayfayı temsil eder.
             * @var integer
             * @example 1
             */
            'page' => 'sometimes|integer|min:1',

            /**
             * Listenin kaç adet geleceğini temsil eder.
             * @var integer
             * @example 2
             */
            'limit' => 'sometimes|integer|min:1|max:100',

            /**
             * Cevapların sırlama tipidir
             * @var ["most_popular","most_new"]
             * @example most_popular
             */
            'sort' => 'string|in:most_new,most_popular|nullable',
        ];
    }
}
