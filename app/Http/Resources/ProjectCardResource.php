<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\ProjectStatusTypes;

class ProjectCardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            /**
             * @var int Kullanıcının id'si
             * @example 1
             */
            "id" => $this->id,

            /**
             * @var string Projenin başlığı
             * @example Vestel Buzdolabı Projesi #1
             */
            "title" => $this->title,

            /**
             * @var string Projenin resmi
             * @example image.png
             */
            "cover" => $this->cover,

            /**
             * @var string Projenin başlangıç tarihi
             * @example
             */
            "start_date" => $this->start_date,

            /**
             * @var string Projenin bitiş tarihi
             * @example
             */
            "end_date" => $this->end_date,


            /**
             * @var ProjectStatusTypes Projenin durumunu belirtir. "pending":"Beklemede", "in_process":"İşlemde", "completed":"Tamamlandı"
             * @example pending
             */
            "status" => $this->status,

            /**
             * @var boolean Projenin yeni olup olmadığını belirten veridir. Yeni ise true yeni değilse false döner
             * @example
             */
            'is_new' => !(Carbon::parse($this->start_date)->addMonth())->lt(Carbon::now()),

            /**
             * @var string Projedeki toplam task sayısı
             * @example 1
             */
            "total_task_count" => $this->total_task_count,

            /**
             * @var string Projedeki toplam tamamlanmış task sayısı
             * @example 1
             */
            "total_completed_task_count" => $this->total_completed_task_count,

            /**
             * @var int Kullanıcının oluşturma tarihi
             * @example 1
             */
            "created_at" => $this->created_at,
        ];
    }
}
