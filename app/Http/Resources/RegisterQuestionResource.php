<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterQuestionResource extends JsonResource
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
             * @var int Sorunun ID'si
             * @example 3
             */
            'id' => $this->id,

            /**
             * @var string Sorunun başlığı
             * @example "Eve en çok gelir getiren kişi kimdir?"
             */
            'title' => $this->title,

            /**
             * @var string Sorunun açıklaması
             * @example "Eve en çok gelir getiren kişiyi seçin"
             */
            'description' => $this->description,

            /**
             * @var int Sorunun sıralaması
             * @example 3
             */
            'sort' => $this->sort,

            /**
             * @var int Sorunun aktif olup olmadığı
             * @example 1
             */
            'is_active' => $this->is_active,

            /**
             * @var string Sorunun tipi
             * @example "text"
             */
            'question_type' => $this->question_type,

            /**
             * @var string Sorunun oluşturulma tarihi
             * @example "2024-07-04T17:08:32.000000Z"
             */
            'created_at' => $this->created_at,

            /**
             * @var string Sorunun güncellenme tarihi
             * @example "2024-07-04T17:08:32.000000Z"
             */
            'updated_at' => $this->updated_at,

            /**
             * @var RegisterOptionResource[]|null Sorunun seçenekleri
             *
             */
            'options' => RegisterOptionResource::collection($this->options),
        ];
    }
}
