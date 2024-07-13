<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
             * @var int Görevin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Görevin ait olduğu projenin id'si
             * @example 2
             */
            'project_id' => $this->project_id,

            /**
             * @var string Görevin başlığı
             * @example Yeni Görev
             */
            'title' => $this->title,

            /**
             * @var string Görevin açıklaması
             * @example Bu görev ...
             */
            'description' => $this->description,

            /**
             * @var string Görevin kapak resmi
             * @example cover.jpg
             */
            'cover' => $this->cover,

            /**
             * @var string Görevin başlangıç tarihi
             * @example 2024-07-01
             */
            'start_date' => $this->start_date,

            /**
             * @var string Görevin bitiş tarihi
             * @example 2024-12-31
             */
            'end_date' => $this->end_date,

            /**
             * @var int Görevin sıralaması
             * @example 1
             */
            'sort' => $this->sort,

            /**
             * @var string Görevin durumu
             * @example pending
             */
            'status' => $this->status,

            /**
             * @var string Görevin oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Görevin güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,

        ];
    }
}
