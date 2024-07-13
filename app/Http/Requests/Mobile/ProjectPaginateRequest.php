<?php

namespace App\Http\Requests\Mobile;

use Illuminate\Foundation\Http\FormRequest;

class ProjectPaginateRequest extends FormRequest
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
             * Projenin kategorisine göre listeleme yapılmak istenirse kategorinin ID'si gönderilmelidr. Eğer kategori bağımsız listenlenmes istenirse null gönderilmelidir.
             * @var integer
             * @example null
             */
            'category_id' => 'sometimes|integer|nullable',

            /**
             * Gelecek projelerin listelenmesi için kullanılan bir parametredir. Eğer gelecek projelerin listelenmesi istenir ise o zaman "true" olarak gönderilmesi gerekir. Tümü için "null" değeri gönderiniz. Devam eden projeler için "false" değerini göndermeniz gerekir.
             * @var bool
             * @example null
             */
            'is_future' => 'string|in:true,false|nullable',

            /**
             * Listede string arama yapmak için kullanılır. Arka planda default ara parametrelerine göre arama yapılır
             * @var string
             * @example
             */
            'search' => 'sometimes|string'
        ];
    }
}
