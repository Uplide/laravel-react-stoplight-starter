<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            /**
             * @var int Seçeneğin ID'si
             * @example 10
             */
            'id' => $this->id,

            /**
             * @var string Seçeneğin değeri
             * @example "Benim"
             */
            'value' => $this->value,

            /**
             * @var int Seçeneğin sırası
             * @example 1
             */
            'sort' => $this->sort,

            /**
             * @var int Seçeneğin aktif olup olmadığı
             * @example 1
             */
            'is_active' => $this->is_active,

            /**
             * @var int Seçeneğin bağlı olduğu sorunun ID'si
             * @example 3
             */
            'register_question_id' => $this->register_question_id,

            /**
             * @var string Seçeneğin oluşturulma tarihi
             * @example "2024-07-04T17:08:32.000000Z"
             */
            'created_at' => $this->created_at,

            /**
             * @var string Seçeneğin güncellenme tarihi
             * @example "2024-07-04T17:08:32.000000Z"
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
