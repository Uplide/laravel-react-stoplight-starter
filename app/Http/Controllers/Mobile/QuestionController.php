<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\QuestionAnswerPaginateRequest;
use App\Http\Resources\Mobile\QuestionGetResource;
use App\Http\Resources\PaginateMetaResourece;
use App\Http\Resources\UserQuestionAnswerResource;
use App\Models\Question;
use App\Models\UserQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @tags 😸 Mobile > 6 > Question
 */
class QuestionController extends Controller
{

    /**
     * Get Question
     *
     * Bu servis sorunun detayını döndürür
     *
     */
    public function getQuestion(Request $request)
    {
        $userId = null;
        $questionId = intval($request->id);
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $question = Question::where("id", $questionId)
            ->withAnsweredOptions($userId)
            ->withCount(
                ['answers as is_answered' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }]
            )
            ->first();

        return new QuestionGetResource($question);
    }

    /**
     * Get Question Answers
     *
     * Bu servis sorunun cevaplarıni paginate şekilde döndürür.
     *
     */
    public function getQuestionAnswers(QuestionAnswerPaginateRequest $request)
    {
        $userId = null;
        $questionId = intval($request->id);
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $sort = $request->input('sort', null);

        $paginate = UserQuestionAnswer::where("question_id", $questionId)
            ->with(
                [
                    "user",
                    "subAnswers",
                    "answerOptions",
                    "answerOptions.option",
                    "likes" => function ($query) use ($userId) {
                        $query->where('user_id',  $userId);
                    }
                ]
            )
            ->where("parent_id", null);

        if ($sort === "most_popular") {
            $paginate = $paginate->orderBy("like_count", "desc");
        }

        if ($sort === "most_new") {
            $paginate = $paginate->orderBy("created_at", "desc");
        }

        $paginate = $paginate->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'items' => UserQuestionAnswerResource::collection($paginate->items()),
            "meta" => new PaginateMetaResourece(collect([
                'currentPage' => $paginate->currentPage(),
                'totalPages' => ceil($paginate->total() / $paginate->perPage()),
                'itemsPerPage' => $paginate->perPage(),
                "itemCount" => count($paginate->items()),
                "totalItems" => $paginate->total(),
            ])),
        ]);
    }
}
