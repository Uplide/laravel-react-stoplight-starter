<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
             * @var int Kullanıcının id'si
             * @example 1
             */
            "id" => $this->id,

            /**
             * @var string Kullanıcının adı
             * @example Feyyaz Can
             */
            "name" => $this->name,

            /**
             * @var string Kullanıcının soyadı
             * @example Köse
             */
            "surname" => $this->surname,

            /**
             * @var string Kullanıcının telefon numarası
             * @example 905419232323
             */
            "phone" => $this->phone,

            /**
             * @var string Kullanıcının telefon numarasındaki telefon kodu
             * @example +90
             */
            "phone_code" => $this->phone_code,

            /**
             * @var string Kullanıcının e-posta adresi
             * @example kesemenere123@gmail.com
             */
            "email" => $this->email,


            /**
             * @var int Kullanıcının oluşturma tarihi
             * @example 1
             */
            "created_at" => $this->created_at,
        ];
    }
}
