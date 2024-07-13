<?php

namespace App\Http\Controllers\Mobile\Answer;

use App\Enums\QuestionTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Answer\AnswerImageTextRequest;
use App\Models\ProjectUser;
use App\Models\Question;
use App\Models\UserQuestionAnswer;
use App\Modules\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

/**
 * @tags 😸 Mobile > 7 > Answer
 */
class AnswerImageTextController extends Controller
{

    public $prefix = "answers/images/";

    /**
     * Create Image Text Answer
     *
     * Bu servis soru tipi resim & metin ise kullanılması gereken servistir.
     *
     * @requestMediaType multipart/form-data
     *
     */
    public function create(AnswerImageTextRequest $request)
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

        if ($question->option_type !== QuestionTypes::TEXT_IMAGE->value) {
            abort(response()->json([
                "message" => "Sadece resim & metin tipindeki sorular için cevap gönderilebilir."
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

            $filePath = uniqid() . Helper::makeId(20) . "." . $request->image->getClientOriginalExtension();

            $destinationPath = public_path($this->prefix);
            $request->image->move($destinationPath, $filePath);

            $userQuestionAnswer = UserQuestionAnswer::create([
                "user_id" => $userId,
                "image_path" => env("APP_URL") . "/" . $this->prefix . $filePath,
                "question_id" => $question->id,
                "text_answer" => $request->text_answer,
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
     * Update Image Text Answer
     *
     * Bu servis soru tipi resim & metin ise kullanılması gereken servistir.
     *
     * @requestMediaType multipart/form-data
     *
     */
    public function update(AnswerImageTextRequest $request)
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

        if ($question->option_type !== QuestionTypes::TEXT_IMAGE->value) {
            abort(response()->json([
                "message" => "Sadece resim & metin tipindeki sorular için cevap gönderilebilir."
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

        $getFileName = Helper::getFileName(
            separator: env("APP_URL") . "/" . $this->prefix,
            path: $answer->image_path,
            newExtension: $request->image->getClientOriginalExtension(),
            prefix: $this->prefix
        );

        if (File::exists(public_path($getFileName["filePath"])) && !$getFileName["isExtensionEqual"]) {
            File::delete(public_path($getFileName["filePath"]));
        }

        $destinationPath = public_path($this->prefix);
        $request->image->move($destinationPath, $getFileName["fileNameNewExtension"]);

        $userQuestionAnswer = $answer->update([
            "image_path" =>  env("APP_URL") . "/" . $this->prefix . $getFileName["fileNameNewExtension"],
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
