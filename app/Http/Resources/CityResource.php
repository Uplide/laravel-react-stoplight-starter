<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
             * @var int Şehrin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var string Şehrin adı
             * @example 'Adana'
             */
            'city_name' => $this->city_name,

            /**
             * @var string Şehrin plaka numarası
             * @example '1'
             */
            'plate_no' => $this->plate_no,

            /**
             * @var string Şehrin telefon kodu
             * @example '322'
             */
            'phone_code' => $this->phone_code,

            /**
             * @var int Şehrin durumu
             * @example 1
             */
            'status' => $this->status,

            /**
             * @var int Şehrin bağlı olduğu ülkenin id'si
             * @example 212
             */
            'country_id' => $this->country_id,

            /**
             * @var float Şehrin enlemi
             * @example 37.0
             */
            'latitude' => $this->latitude,

            /**
             * @var float Şehrin boylamı
             * @example 35.3213
             */
            'longitude' => $this->longitude,
        ];
    }
}
