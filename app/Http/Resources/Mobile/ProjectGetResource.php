<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
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

            /**
             * Projenin kategorilerini verir
             */
            'categories' => CategoryResource::collection($this->categories),

            /**
             * Projenin şirketidir.
             */
            'company' => new CompanyResource($this->company),

            /**
             * Projenin tanımlanmış görevlerini verir.
             */
            'tasks' =>  TaskListResource::collection($this->tasks),
        ];
    }
}
