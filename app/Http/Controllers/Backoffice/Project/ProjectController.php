<?php

namespace App\Http\Controllers\Backoffice\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\ProjectRequest;
use App\Http\Requests\Backoffice\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Modules\Filter\FilterService;
use App\Modules\Filter\FilterTableRequest;

/**
 * @tags 😻 Dashboard > 4 > Projects
 */
class ProjectController extends Controller
{
    protected $filterService;

    public function __construct(FilterService $filterService, Request $request)
    {
        $this->filterService = $filterService;
        if (@$request->skip) {
            $this->filterService->skip = intval($request->skip);
        }

        if (@$request->take) {
            $this->filterService->take = intval($request->take);
        }
    }

    /**
     * List Projects
     *
     * Bu servis projeleri listelemek için kullanılmaktadır. Pagianble bir şekilde listeler
     */
    public function index(FilterTableRequest $request)
    {
        $options = $request->all();
        if (!empty($options['group'])) {
            return response()->json(
                $this->filterService->getGroups($request, new Project())
            );
        }

        $query = $this->filterService->getWhereFilter($options, new Project());
        $totalCount = $query->count();
        $items = $query
            ->take($this->filterService->take)
            ->skip(($this->filterService->skip - 1) * $this->filterService->take)
            ->get(['id', 'title', "cover", 'start_date', 'end_date', 'created_at']);

        return response()->json([
            'items' => $items,
            'meta' => [
                'totalItems' => $totalCount,
                'itemCount' => $items->count(),
                'itemsPerPage' => (int) $this->filterService->take,
                'totalPages' => ceil($totalCount / (int) $this->filterService->take),
                'currentPage' => (int) $this->filterService->skip,
            ],
        ]);
    }

    /**
     * Get Project
     *
     * Bu servis proje bilgilerini getirmek için kullanılmaktadır.
     */
    public function show(Request $request)
    {
        $project = Project::where("id", intval($request->route("id")))->first();
        if (!@$project->id) {
            return response()->json([
                'message' => 'Proje bulunamadı.',
            ], 404);
        }

        return response()->json($project, 200);
    }

    /**
     * Create Project
     *
     * Bu servis proje oluşturmak için kullanılmaktadır.
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());
        $project = ProjectHelper::task($request, $project);
        $project = ProjectHelper::announcement($request, $project);
        $project = ProjectHelper::targetGroup($request, $project);
        $project = ProjectHelper::mod($request, $project);
        $project = ProjectHelper::observer($request, $project);

        return response()->json([
            "message" => "Proje oluşturuldu.",
            "project" => $project->load(['tasks.questions.options', 'announcements', 'targetGroups.targetGroupUsers.user', 'projectMods.mod', 'projectObservers.observer'])
        ], 201);
    }

    /**
     * Update Project
     *
     * Bu servis projeyi düzenlemek için kullanılmaktadır.
     */
    public function update(ProjectUpdateRequest $request, $id)
    {
        $project = Project::where("id", intval($id))->first();
        if (!@$project->id) {
            return response()->json([
                'message' => 'Proje bulunamadı!',
            ], 422);
        }

        $project->update($request->all());

        return response()->json([
            'message' => 'Proje düzenlendi.',
            'project' => $project
        ], 200);
    }

    /**
     * Delete Project
     *
     * Bu servis projeyi silmek için kullanılmaktadır.
     */
    public function destroy(Request $request)
    {
        $project = Project::where("id", intval($request->route("id")))->first();
        if (!@$project->id) {
            return response()->json([
                'message' => 'Proje bulunamadı.',
            ], 404);
        }

        $project->delete();

        return response()->json([
            "message" => "Silme işlemi başarılı"
        ], 200);
    }

    private function taskCreate(ProjectRequest $request, $project)
    {
        // Tasks and their related data
        if ($request->has('tasks')) {
            foreach ($request->tasks as $taskData) {
                $task = $project->tasks()->create($taskData);

                if (isset($taskData['questions'])) {
                    foreach ($taskData['questions'] as $questionData) {
                        $question = $task->questions()->create($questionData);

                        if (isset($questionData['options'])) {
                            foreach ($questionData['options'] as $optionData) {
                                $question->options()->create($optionData);
                            }
                        }
                    }
                }
            }
        }

        return $project;
    }
}
