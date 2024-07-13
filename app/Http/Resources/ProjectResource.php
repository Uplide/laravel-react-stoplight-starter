<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
             * @var int Projenin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var string Projenin başlığı
             * @example Yeni Proje
             */
            'title' => $this->title,

            /**
             * @var string Projenin koşullarıdır
             * @example Bu proje ...
             */
            'conditions' => $this->conditions,

            /**
             * @var string Projenin açıklaması
             * @example Bu proje ...
             */
            'description' => $this->description,

            /**
             * @var int Projeye ait şirketin id'si
             * @example 2
             */
            'company_id' => $this->company_id,

            /**
             * @var string Projenin kapak resmi
             * @example cover.jpg
             */
            'cover' => $this->cover,

            /**
             * @var string Projenin başlangıç tarihi
             * @example 2024-07-01
             */
            'start_date' => $this->start_date,

            /**
             * @var string Projenin bitiş tarihi
             * @example 2024-12-31
             */
            'end_date' => $this->end_date,

            /**
             * @var bool Projenin tüm görevleri görüntüleyip görüntülemeyeceği
             * @example true
             */
            'is_view_all_task' => $this->is_view_all_task,

            /**
             * @var string Projenin oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Projenin güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
