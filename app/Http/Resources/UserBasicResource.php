<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBasicResource extends JsonResource
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
        ];
    }
}
