<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\OptionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionGetResource extends JsonResource
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

            /**
             * @var int Sorunun cevaplanıp cevaplanmadığı bilgisini döner. 0 ise cevaplanmamıştır. 0'dan büyük ise cevaplanmıştır.
             * @example 1
             */
            'is_answered' => $this->is_answered,

            /**
             * @var bool Sorunun güncellenip güncellenemeyeceğini döner.
             * @example false
             */
            'is_editable' => $this->is_editable,

            /**
             * @var OptionResource[] Sorunun tipi seçenekli soru ise sorunun seçeneklerinin yer aldığı dizidir.
             */
            'options' => OptionResource::collection($this->options)
        ];
    }
}
