<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
             * @var int Kategorinin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var string Kategorinin başlığı
             * @example Teknoloji
             */
            'title' => $this->title,

            /**
             * @var string Kategorinin kapak resmi
             * @example cover.jpg
             */
            'cover' => $this->cover,

            /**
             * @var int Kategorinin sıralaması
             * @example 1
             */
            'sort' => $this->sort,

            /**
             * @var string Kategorinin rengi
             * @example #3A6BE4
             */
            'color' => $this->color,

            /**
             * @var string Kategorinin oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Kategorinin güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
