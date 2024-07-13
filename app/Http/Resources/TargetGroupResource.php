<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TargetGroupResource extends JsonResource
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
             * @var int Hedef grubun id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Hedef grubun ait olduğu projenin id'si
             * @example 2
             */
            'project_id' => $this->project_id,

            /**
             * @var string Hedef grubun başlığı
             * @example Yeni Hedef Grup
             */
            'title' => $this->title,

            /**
             * @var string Hedef grubun açıklaması
             * @example Bu hedef grup ...
             */
            'description' => $this->description,

            /**
             * @var string Hedef grubun SES durumu
             * @example HIGH
             */
            'ses' => $this->ses,

            /**
             * @var string Hedef grubun oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Hedef grubun güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
