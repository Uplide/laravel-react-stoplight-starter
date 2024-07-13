<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStepRequest extends FormRequest
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
             * Bu alan kullanıcının doğum tarihidir. (YYYY-MM-DD) formatında olmalıdır
             * @var date
             * @example 2023-06-01
             */
            'birthday' => [
                'required',
                'string',
                'date_format:"Y-m-d"'
            ],

            /**
             * Seçilen ülke ID'si
             * @var integer
             * @example 1
             */
            'country_id' => [
                'required',
                'integer',
            ],

            /**
             * Seçilen şehir ID'si
             * @var integer
             * @example 2
             */
            'city_id' => [
                'required',
                'integer',
            ],

            /**
             * Seçilen ilçe ID'si
             * @var integer
             * @example 19
             */
            'town_id' => [
                'required',
                'integer',
            ],

            /**
             * Sorular ve cevaplar
             */
            'questions' => [
                'required',
                'array',
            ],

            /**
             * Soru ID'si
             * @var integer
             * @example 1
             */
            'questions.*.id' => [
                'required',
                'integer',
            ],

            /**
             * Eğer soru tipi "text" ise text cevabı
             * @var string
             * @example Selam...
             */
            'questions.*.answer' => [
                'string',
                "nullable"
            ],

            /**
             * Eğer sorunun tipi "single_select" veya "multiple_select" ise bu alan kullanılır.
             * @var array
             */
            'questions.*.options' => [
                'array',
                "nullable"
            ],

            /**
             * Seçenek ID'si
             * @var integer
             * @example 1
             */
            'questions.*.options.*.id' => [
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
    public function messages()
    {
        return [
            'birthday.required' => 'Doğum tarihi gereklidir.',
            'birthday.string' => 'Doğum tarihi tarih formatında olmalıdır.',
            'birthday.date_format' => 'Doğum tarihi YYYY-MM-DD formatında olmalıdır.',

            'country_id.required' => 'Ülke ID gereklidir.',
            'country_id.integer' => 'Ülke ID bir tamsayı olmalıdır.',

            'city_id.required' => 'Şehir ID gereklidir.',
            'city_id.integer' => 'Şehir ID bir tamsayı olmalıdır.',

            'town_id.required' => 'İlçe ID gereklidir.',
            'town_id.integer' => 'İlçe ID bir tamsayı olmalıdır.',

            'questions.required' => 'Sorular gereklidir.',
            'questions.array' => 'Sorular bir dizi olmalıdır.',

            'questions.*.id.integer' => 'Her sorunun ID\'si bir tamsayı olmalıdır.',

            'questions.*.answer.string' => 'Her sorunun cevabı bir metin olmalıdır.',

            'questions.*.options.array' => 'Her sorunun seçenekleri bir dizi olmalıdır.',

            'questions.*.options.*.id.integer' => 'Her seçeneğin ID\'si bir tamsayı olmalıdır.',
        ];
    }
}
