<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
             * @var int Sorunun id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Sorunun ait olduğu görevin id'si
             * @example 2
             */
            'task_id' => $this->task_id,

            /**
             * @var string Sorunun başlığı
             * @example Yeni Soru
             */
            'title' => $this->title,

            /**
             * @var string Sorunun açıklaması
             * @example Bu soru ...
             */
            'description' => $this->description,

            /**
             * @var string Sorunun seçenek türü
             * @example text
             */
            'option_type' => $this->option_type,

            /**
             * @var int Sorunun sıralaması
             * @example 1
             */
            'sort' => $this->sort,

            /**
             * @var string Sorunun oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Sorunun güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
