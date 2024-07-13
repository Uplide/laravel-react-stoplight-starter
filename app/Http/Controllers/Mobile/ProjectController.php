<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\ProjectPaginateRequest;
use App\Http\Resources\Mobile\ProjectGetResource;
use App\Http\Resources\PaginateMetaResourece;
use App\Http\Resources\ProjectCardResource;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * @tags 😸 Mobile > 4 > Project
 */
class ProjectController extends Controller
{

    /**
     * List Projects
     *
     * Bu servis sisteme giriş yapmış kullanıcının projelerini döndürür.
     */
    public function projects(ProjectPaginateRequest $request)
    {
        $userId = null;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $categoryId = $request->input('category_id', null);
        $isFuture = $request->input('is_future', null);
        $search = $request->input('search', "");

        $paginate = DB::table('projects')
            ->leftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->leftJoin('task_users', function ($join) use ($userId) {
                $join->on('tasks.id', '=', 'task_users.task_id')
                    ->where('task_users.user_id', '=', $userId);
            })
            ->join('project_users', 'projects.id', '=', 'project_users.project_id')
            ->leftJoin('project_categories', 'projects.id', '=', 'project_categories.project_id')
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
            ->where('project_users.user_id', $userId);

        if ($search) {
            $paginate = $paginate->where("projects.title", "LIKE", "%{$search}%");
        }

        if ($categoryId) {
            $paginate = $paginate->where("project_categories.category_id", $categoryId);
        }

        if ($isFuture && $isFuture === "true") {
            $paginate = $paginate->where("project_users.status", "pending")->where("projects.start_date", ">", now());
        }

        if ($isFuture && $isFuture === "false") {
            $paginate = $paginate->whereIn("project_users.status", ["pending", "in_process"])->where("projects.start_date", "<", now());
        }

        $paginate = $paginate->groupBy(['projects.id', "project_users.status"])
            ->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'items' => ProjectCardResource::collection($paginate->items()),
            "meta" => new PaginateMetaResourece(collect([
                'currentPage' => $paginate->currentPage(),
                'totalPages' => ceil($paginate->total() / $paginate->perPage()),
                'itemsPerPage' => $paginate->perPage(),
                "itemCount" => count($paginate->items()),
                "totalItems" => $paginate->total(),
            ])),
        ]);
    }

    /**
     * Get Project
     *
     * Bu servis verilen proje_id'si ne göre projenin detay bilgilerini döndürür
     */
    public function getProject(Request $request)
    {
        $userId = null;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $isUserRelated = ProjectUser::where('project_id', intval($request->id))
            ->where('user_id', $userId)
            ->exists();

        if ($isUserRelated) {
            $project = Project::where('id', intval($request->id))
                ->with([
                    'categories',
                    'company',
                    'tasks' => function ($query) use ($userId) {
                        $query->withCount(['questions', 'questions as answered_questions_count' => function ($subQuery) use ($userId) {
                            $subQuery->whereHas('answers', function ($answerQuery) use ($userId) {
                                $answerQuery->where('user_id', $userId);
                            });
                        }])->orderBy('sort', "asc");
                    }
                ])
                ->first();

            if ($project) {
                return new ProjectGetResource($project);
            }
        }

        return response()->json(['message' => 'Proje bulunamadı!'], 404);
    }
}
