<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
             * @var int Ülkenin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var string Ülkenin ikili kodu
             * @example 'AF'
             */
            'binary_code' => $this->binary_code,

            /**
             * @var string Ülkenin üçlü kodu
             * @example 'AFG'
             */
            'triple_code' => $this->triple_code,

            /**
             * @var string Ülkenin adı
             * @example 'Afghanistan'
             */
            'country_name' => $this->country_name,

            /**
             * @var string Ülkenin telefon kodu
             * @example '93'
             */
            'phone_code' => $this->phone_code,

            /**
             * @var int Ülkenin durumu
             * @example 1
             */
            'status' => $this->status,
        ];
    }
}
