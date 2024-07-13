<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
             * @var int Şirketin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var string Şirketin adı
             * @example XYZ Ltd. Şti.
             */
            'name' => $this->name,

            /**
             * @var string Şirketin logosu
             * @example logo.png
             */
            'logo' => $this->logo,

            /**
             * @var string Şirketin e-posta adresi
             * @example info@xyz.com
             */
            'email' => $this->email,

            /**
             * @var string Şirketin telefon numarası
             * @example 905419232323
             */
            'phone' => $this->phone,

            /**
             * @var string Şirketin telefon kodu
             * @example +90
             */
            'phone_code' => $this->phone_code,

            /**
             * @var string Şirketin adresi
             * @example İstanbul, Türkiye
             */
            'address' => $this->address,

            /**
             * @var string Şirketin açıklaması
             * @example Bu şirket ...
             */
            'description' => $this->description,

            /**
             * @var string Şirketin oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Şirketin güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
