<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserQuestionAnswerResource extends JsonResource
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
             * @var int Kullanıcı cevaplarının id'si
             * @example 1
             */
            'id' => $this->id,

            /**
             * @var int Kullanıcının id'si
             * @example 3
             */
            'user_id' => $this->user_id,

            /**
             * @var int Sorunun id'si
             * @example 5
             */
            'question_id' => $this->question_id,

            /**
             * @var string Kullanıcının metin cevabı
             * @example Bu bir metin cevabıdır.
             */
            'text_answer' => $this->text_answer,

            /**
             * @var int Cevabın beğeni sayısı
             * @example 10
             */
            'like_count' => $this->like_count,

            /**
             * @var bool Giriş yapmış kullanıcı cevabı beğendi mi?
             * @example true
             */
            'liked_by_current_user' => $this->likes->isNotEmpty(),

            /**
             * @var string Kullanıcının video cevabı
             * @example /videos/cevap.mp4
             */
            'video_path' => $this->video_path,

            /**
             * @var string Kullanıcının resim cevabı
             * @example /images/cevap.jpg
             */
            'image_path' => $this->image_path,

            /**
             * @var int Üst cevap id'si
             * @example 2
             */
            'parent_id' => $this->parent_id,

            /**
             * @var string Cevabın oluşturulma tarihi
             * @example 2024-07-01 12:34:56
             */
            'created_at' => $this->created_at,

            /**
             * @var string Cevabın güncellenme tarihi
             * @example 2024-07-01 12:34:56
             */
            'updated_at' => $this->updated_at,

            /**
             * @var UserBasicResource Kullanıcının basic verisidir.
             */
            'user' =>  new UserBasicResource($this->user),


            /**
             * @var AnswerOptionResourceResource[] seçenekli soruların cevapları için kullanılır.
             */
            'answer_options' => AnswerOptionResourceResource::collection($this->answerOptions)
        ];
    }
}
