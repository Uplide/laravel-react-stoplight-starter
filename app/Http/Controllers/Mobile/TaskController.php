<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\TaskResource;
use App\Models\ProjectUser;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @tags 😸 Mobile > 5 > Task
 */
class TaskController extends Controller
{

    /**
     * Get Task
     *
     * Bu servis giriş yapmış kullanıcının görevinin detayını döndürür
     *
     */
    public function getTask(Request $request)
    {
        $userId = null;
        $taskId = intval($request->id);
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task = Task::where("id", $taskId)
            ->with([
                'questions' => function ($query) use ($userId) {
                    $query->withCount(['answers as is_answered' => function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    }])->orderBy('sort', "asc");
                }
            ])->withCount([
                'questions',
                'questions as answered_questions_count' => function ($subQuery) use ($userId) {
                    $subQuery->whereHas('answers', function ($answerQuery) use ($userId) {
                        $answerQuery->where('user_id', $userId);
                    });
                }
            ])->first();

        if ($task) {
            $isUserRelated = ProjectUser::where('project_id', $task->project_id)
                ->where('user_id', $userId)
                ->exists();

            if ($isUserRelated) {
                return new TaskResource($task);
            }
        }

        return response()->json(['message' => 'Görev bulunamadı!'], 404);
    }
}
