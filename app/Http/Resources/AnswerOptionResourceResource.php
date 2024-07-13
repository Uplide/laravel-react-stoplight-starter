<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerOptionResourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * @var int Cevap seçeneğinin id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Kullanıcı cevabının id'si
             * @example 4
             */
            'user_question_answer_id' => $this->user_question_answer_id,

            /**
             * @var int Seçeneğin id'si
             * @example 1
             */
            'option_id' => $this->option_id,

            /**
             * @var string Cevap seçeneğinin oluşturulma tarihi
             * @example 2024-07-07T21:21:21.000000Z
             */
            'created_at' => $this->created_at,

            /**
             * @var string Cevap seçeneğinin güncellenme tarihi
             * @example 2024-07-07T21:21:21.000000Z
             */
            'updated_at' => $this->updated_at,

            /**
             * İlgili seçenek verileri
             */
            'option' => new OptionResource($this->whenLoaded('option')),
        ];
    }
}
