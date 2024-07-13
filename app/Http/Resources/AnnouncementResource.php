<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
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
             * @var int Duyurunun id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Duyurunun ait olduğu projenin id'si
             * @example 2
             */
            'project_id' => $this->project_id,

            /**
             * @var string Duyurunun başlığı
             * @example Yeni Duyuru
             */
            'title' => $this->title,

            /**
             * @var string Duyurunun açıklaması
             * @example Bu duyuru ...
             */
            'description' => $this->description,

            /**
             * @var string Duyurunun kapak resmi
             * @example cover.jpg
             */
            'cover' => $this->cover,

            /**
             * @var int Duyurunun sıralaması
             * @example 1
             */
            'sort' => $this->sort,

            /**
             * @var bool Duyurunun aktiflik durumu
             * @example true
             */
            'is_active' => $this->is_active,

            /**
             * @var string Duyurunun oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Duyurunun güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
