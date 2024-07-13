<?php

namespace App\Http\Controllers\Mobile;

use App\Enums\ProjectStatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\FeedbackRequest;
use App\Http\Resources\ProjectCardResource;
use App\Http\Resources\UserResource;
use App\Models\Feedback;
use App\Models\ProjectUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @tags 😸 Mobile > 2 > Profile
 */
class ProfileController extends Controller
{

    /**
     * Profile
     *
     * Bu servis sisteme giriş yapmış kullanıcının profil bilgilerinin çekildiği servistir.
     */
    public function profile()
    {
        $userId = null;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($userId);

        if (!$user) {
            abort(response()->json([
                "Kullanıcı bulunamadı"
            ], 400));
        }

        $projectCompletedCount = ProjectUser::where("user_id", $userId)->where("status", ProjectStatusTypes::COMPLETED->value)->count();
        $projectCount = ProjectUser::where("user_id", $userId)->count();
        $rank = DB::table('users')
            ->select(DB::raw('COUNT(*) + 1 AS user_rank'))
            ->where('user_total_answer', '>=', function ($query) use ($userId) {
                $query->select('user_total_answer')
                    ->from('users')
                    ->where('id', $userId)
                    ->limit(1);
            })
            ->first()
            ->user_rank;

        $projects = DB::table('projects')
            ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->leftJoin('task_users', function ($join) use ($userId) {
                $join->on('tasks.id', '=', 'task_users.task_id')
                    ->where('task_users.user_id', '=', $userId);
            })
            ->join('project_users', 'projects.id', '=', 'project_users.project_id')
            ->select(
                'projects.id',
                'projects.title',
                'projects.cover',
                'projects.start_date',
                'project_users.status',
                'projects.end_date',
                'projects.created_at',
                DB::raw('COUNT(tasks.id) as total_task_count'),
                DB::raw('CAST(SUM(CASE WHEN task_users.is_completed = true THEN 1 ELSE 0 END) AS UNSIGNED) as total_completed_task_count')
            )
            ->where('project_users.user_id', $userId)
            ->groupBy('projects.id', "project_users.status")
            ->get();


        return [
            /**
             * @var int Toplam geçirilen süre
             * @example 1
             */
            "total_hours" => (@$user->user_total_answer ?? 0) * intval(env("QUESTION_ESTIMATED_RESPONSE_TIME")) / 60,

            /**
             * @var int Toplam proje sayısı
             * @example 1
             */
            "total_projects" => $projectCount,

            /**
             * @var int Toplam tamamlanan proje sayısı
             * @example 1
             */
            "total_completed_projects" => $projectCompletedCount,

            /**
             * @var int Kullanıcılar arasında kaçıncı sırada
             * @example 8
             */
            "rank" => $rank,

            /** @var UserResource */
            "user" => new UserResource($user),

            /** @var array<ProjectCardResource> */
            "projects" => ProjectCardResource::collection($projects)
        ];
    }

    /**
     * Feedback
     *
     * Bu servis sisteme giriş yapmış kullanıcının feedback yapabilmesi için gerekli servistir.
     */
    public function feedback(FeedbackRequest $request)
    {
        $userId = null;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $feedbackHour = intval(env("FEEDBACK_USEGE_HOUR", "6"));
        if (Feedback::where("user_id", $userId)->where("created_at", "<", Carbon::now()->addHour($feedbackHour))->first()) {
            return response()->json([
                /**
                 * @var string Mesaj
                 * @example Geri bildiriminiz 3 saat sonra kullanıma açılacaktır.
                 */
                'message' => 'Geri bildirim ' . $feedbackHour . ' saat sonra yapılabilir.',
            ], 400);
        }

        Feedback::create([
            "message" => $request->message,
            "star" => $request->star,
            "user_id" => $userId
        ]);

        return response()->json([
            /**
             * @var string Mesaj
             * @example Geri bildirim kayıt edildi.
             */
            'message' => 'Geri bildirim kayıt edildi.',
        ], 201);
    }
}
