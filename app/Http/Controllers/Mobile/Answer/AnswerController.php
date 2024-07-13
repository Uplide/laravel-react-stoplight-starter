<?php

namespace App\Http\Controllers\Mobile\Answer;

use App\Http\Controllers\Controller;
use App\Models\UserQuestionAnswer;
use App\Models\UserQuestionAnswerLike;
use App\Modules\Helper;
use Illuminate\Support\Facades\Auth;

/**
 * @tags 😸 Mobile > 7 > Answer
 */
class AnswerController extends Controller
{
    /**
     * Like Answer
     *
     * Bu servis herhangi bir cevabın beğenilmesi veya beğeninin geri çekilmesi ile ilgilidir.
     */
    public function like($id)
    {
        $userId = null;
        $answerId = Helper::intval($id);
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $like = UserQuestionAnswerLike::where("user_question_answer_id", $answerId)
            ->where("user_id", $userId)
            ->first();

        $answer = UserQuestionAnswer::where("id", $answerId)->first();

        if ($answer && $like) {
            UserQuestionAnswerLike::where("id", $like->id)->delete();
            $answer->like_count = $answer->like_count - 1;
            $answer->save();

            if ($answer->save()) {
                return response()->json([
                    "message" => "Beğeni geri alındı."
                ], 200);
            }
        } else {
            UserQuestionAnswerLike::create([
                "user_id" => $userId,
                "user_question_answer_id" => $answerId
            ]);

            $answer->like_count = $answer->like_count + 1;
            if ($answer->save()) {
                return response()->json([
                    "message" => "Cevap beğenildi."
                ], 200);
            }
        }

        abort(response()->json([
            "message" => "Teknik bir sorun yaşanıyor."
        ], 500));
    }
}
