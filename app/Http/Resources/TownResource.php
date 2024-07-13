<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TownResource extends JsonResource
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
             * @var int İlçenin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int İlçenin bağlı olduğu şehrin id'si
             * @example 1
             */
            'city_id' => $this->city_id,

            /**
             * @var string İlçenin adı
             * @example 'ALADAĞ'
             */
            'town_name' => $this->town_name,

            /**
             * @var float İlçenin enlemi
             * @example 37.546379
             */
            'latitude' => $this->latitude,

            /**
             * @var float İlçenin boylamı
             * @example 35.402962
             */
            'longitude' => $this->longitude,

            /**
             * @var int İlçenin durumu
             * @example 1
             */
            'status' => $this->status,
        ];
    }
}
