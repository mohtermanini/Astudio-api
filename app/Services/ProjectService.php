<?php

namespace App\Services;

use App\Enums\ProjectStatusesEnum;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\DB;
use App\Filters\Project\ProjectFilters;
use App\Models\Project;
use App\Notifications\ProjectCreatedNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ProjectService
{
    public function getProjects($filters, $pageSize = null)
    {
        $queryBuilder = Project::with(['department', 'status'])
            ->select('*');

        $filteredProjects = app(ProjectFilters::class)->filter([
            'queryBuilder' => $queryBuilder,
            'params' => $filters
        ]);

        $projects = $filteredProjects->when($pageSize, fn($query) => $query->paginate($pageSize), fn($query) => $query->get());

        return $projects;
    }

    public function getProject($id)
    {
        $project = Project::with(['department', 'status'])->find($id);
        if (!$project) {
            throw new \Exception('Project Not Found.', 404);
        }

        return $project;
    }

    public function createFromRequest($request)
    {
        $project = null;

        DB::transaction(function () use ($request, &$project) {
            $project = Project::create([
                'name' => $request->name,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
                'status_id' => ProjectStatusesEnum::CREATED,
                'department_id' => $request->departmentId,
            ]);
        });

        if (is_null($project)) {
            throw new \Exception('Failed to create the project.');
        }

        return $project->refresh()->load(['department', 'status']);
    }

    public function updateFromRequest($request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            throw new \Exception('Project not found.', 422);
        }

        DB::transaction(function () use ($request, $project) {
            $project->update([
                'name' => $request->name,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
                'status_id' => $request->statusId,
                'department_id' => $request->departmentId,
            ]);
        });

        return $project->refresh()->load(['department', 'status']);
    }

    public function delete($id)
    {
        $project = Project::find($id);

        if (!$project) {
            throw new \Exception('Project not found.', 422);
        }

        DB::transaction(function () use ($project) {
            $project->timesheets()->delete();
            $project->users()->detach();
            $project->delete();
        });
    }

    public function checkIfUserAssignedToProject($user_id, $projectId)
    {
        if (!ProjectUser::where('user_id', $user_id)->where('project_id', $projectId)->exists()) {
            throw new \Exception('User is not assigned to project.', 422);
        }
    }


    public function checkIfDateWithinProjectDateRange($date, $project)
    {
        $date = new \DateTime($date);
        $startDate = new \DateTime($project->start_date);
        $endDate = new \DateTime($project->end_date);

        if ($date < $startDate || $date > $endDate) {
            throw new \Exception('Date is out of project date range.', 422);
        }
    }
}
