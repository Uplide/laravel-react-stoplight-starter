<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
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
             * @var int Geri bildirimin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var string Geri bildirimin mesajı
             * @example Harika bir uygulama!
             */
            'message' => $this->message,

            /**
             * @var int Geri bildirimin yıldız sayısı
             * @example 5
             */
            'star' => $this->star,

            /**
             * @var int Geri bildirimi yapan kullanıcının id'si
             * @example 1
             */
            'user_id' => $this->user_id,

            /**
             * @var string Geri bildirimin oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Geri bildirimin güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,
        ];
    }
}
