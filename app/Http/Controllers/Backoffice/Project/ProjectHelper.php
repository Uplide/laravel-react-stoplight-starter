<?php

namespace App\Http\Controllers\Backoffice\Project;

use App\Http\Requests\Backoffice\ProjectRequest;
use App\Models\User;

class ProjectHelper
{
    /**
     * @return Project
     */
    public static function task(ProjectRequest $request, $project)
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

    /**
     * @return Project
     */
    public static function announcement(ProjectRequest $request, $project)
    {
        if ($request->has('announcements')) {
            foreach ($request->announcements as $announcementData) {
                $project->announcements()->create($announcementData);
            }
        }

        return $project;
    }

    /**
     * @return Project
     */
    public static function mod(ProjectRequest $request, $project)
    {
        // Project Mods
        if ($request->has('project_mods')) {
            foreach ($request->project_mods as $projectModData) {
                $project->projectMods()->create($projectModData);
            }
        }

        return $project;
    }

    /**
     * @return Project
     */
    public static function observer(ProjectRequest $request, $project)
    {
        // Project Observers
        if ($request->has('project_observers')) {
            foreach ($request->project_observers as $projectObserverData) {
                $project->projectObservers()->create($projectObserverData);
            }
        }


        return $project;
    }


    /**
     * @return Project
     */
    public static function targetGroup(ProjectRequest $request, $project)
    {
        // Target Groups and their related data
        if ($request->has('target_groups')) {
            foreach ($request->target_groups as $targetGroupData) {
                $targetGroup = $project->targetGroups()->create($targetGroupData);

                if (isset($targetGroupData['target_group_users'])) {
                    foreach ($targetGroupData['target_group_users'] as $targetGroupUserData) {
                        $user = null;

                        if (isset($targetGroupUserData['user']['user_id'])) {
                            $user = User::find($targetGroupUserData['user']['user_id']);
                        }

                        if (!$user) {
                            $user = User::create($targetGroupUserData['user']);
                        }

                        $targetGroup->targetGroupUsers()->create([
                            'user_id' => $user->id
                        ]);
                    }
                }
            }
        }
    }
}
