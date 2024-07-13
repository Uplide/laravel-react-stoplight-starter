<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
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
             * @var int Seçeneğin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Seçeneğin ait olduğu sorunun id'si
             * @example 2
             */
            'question_id' => $this->question_id,

            /**
             * @var string Seçeneğin değeri
             * @example A seçeneği
             */
            'option_value' => $this->option_value,

            /**
             * @var int Seçeneğin sıralaması
             * @example 1
             */
            'sort' => $this->sort,

            /**
             * @var string Seçeneğin oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Seçeneğin güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,

            /**
             * @var int Şıkkın işaretlenip işaretlenmediği bilgisini veren değerdir.
             * @example 1
             */
            'is_answered' => @$this->is_answered ?? null,
        ];
    }
}
