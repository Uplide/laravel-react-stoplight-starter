<?php

namespace App\Http\Controllers\Mobile\Answer;

use App\Enums\QuestionTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Answer\AnswerTextRequest;
use App\Models\ProjectUser;
use App\Models\Question;
use App\Models\UserQuestionAnswer;
use App\Modules\Helper;
use Illuminate\Support\Facades\Auth;

/**
 * @tags 😸 Mobile > 7 > Answer
 */
class AnswerTextController extends Controller
{

    /**
     * Create Text Answer
     *
     * Bu servis soru tipi text ise kullanılması gereken servistir.
     *
     */
    public function create(AnswerTextRequest $request)
    {
        $userId = null;
        $questionId = $request->id;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $question = Question::where("id", $questionId)
            ->withCount(
                ['answers as is_answered' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }]
            )
            ->with("task")
            ->first();

        if ($question->option_type !== QuestionTypes::TEXT->value) {
            abort(response()->json([
                "message" => "Sadece metin tipindeki sorular için cevap gönderilebilir."
            ], 400));
        }

        $isUserRelated = ProjectUser::where('project_id', $question->task->project_id)
            ->where('user_id', $userId)
            ->exists();

        if ($isUserRelated) {
            if ($question->is_answered) {
                abort(response()->json([
                    "message" => "Soruya cevap verilmiş bu nedenle tekrar cevap gönderemezsiniz!"
                ], 400));
            }

            $userQuestionAnswer = UserQuestionAnswer::create([
                "user_id" => $userId,
                "text_answer" => $request->text_answer,
                "question_id" => $question->id
            ]);


            if ($userQuestionAnswer) {
                return response()->json([
                    "message" => "Cevabınız alında teşekkür ederiz."
                ], 200);
            }
        }

        abort(response()->json([
            "message" => "Teknik bir sorun yaşanıyor."
        ], 500));
    }

    /**
     * Update Text Answer
     *
     * Bu servis soru tipi text ise kullanılması gereken servistir.
     *
     */
    public function update(AnswerTextRequest $request)
    {
        $userId = null;
        $questionId = $request->id;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $question = Question::where("id", $questionId)
            ->with(
                ['answers' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }]
            )
            ->with("task")
            ->first();

        if ($question->option_type !== QuestionTypes::TEXT->value) {
            abort(response()->json([
                "message" => "Sadece metin tipindeki sorular için cevap gönderilebilir."
            ], 400));
        }

        if (!$question->is_editable) {
            abort(response()->json([
                "message" => "Cevabınızın düzenleme modu aktif değil!"
            ], 400));
        }

        if (!$question->answers) {
            abort(response()->json([
                "message" => "Soruyu güncellemek için öncelikle soruyu cevaplamanız gerekir."
            ], 400));
        }

        $answer = UserQuestionAnswer::where("id", @$question->answers[0]->id)
            ->where("user_id", $userId)->first();

        if (!$answer) {
            abort(response()->json([
                "message" => "Cevap bulunamadı!"
            ], 404));
        }

        $userQuestionAnswer = UserQuestionAnswer::where("id", $answer->id)->update([
            "text_answer" => $request->text_answer,
            "is_editable" => false
        ]);

        if ($userQuestionAnswer) {
            return response()->json([
                "message" => "Cevabınız güncellendi teşekkür ederiz."
            ], 200);
        }

        abort(response()->json([
            "message" => "Teknik bir sorun yaşanıyor."
        ], 500));
    }
}
