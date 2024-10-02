<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use App\Filters\Timesheet\TimesheetFilters;
use App\Models\Timesheet;

class TimesheetService
{
    public function getTimesheets($filters, $pageSize = null)
    {
        $queryBuilder = Timesheet::with(['user', 'project', 'project.department', 'project.status'])
            ->select('*');

        $filteredTimesheets = app(TimesheetFilters::class)->filter([
            'queryBuilder' => $queryBuilder,
            'params' => $filters
        ]);

        $timesheets = $filteredTimesheets->when($pageSize, fn($query) => $query->paginate($pageSize), fn($query) => $query->get());

        return $timesheets;
    }

    public function getTimesheet($id)
    {
        $timesheet = Timesheet::with(['user', 'project', 'project.department', 'project.status'])->find($id);
        if (!$timesheet) {
            throw new \Exception('Timesheet Not Found.', 404);
        }

        return $timesheet;
    }

    public function createFromRequest($request)
    {
        $timesheet = null;
        $projectService = new ProjectService();
        $projectService->checkIfUserAssignedToProject($request->userId, $request->projectId);

        $project = Project::find($request->projectId);
        if (!$project) {
            throw new \Exception('Project not found.', 422);
        }

        $projectService->checkIfDateWithinProjectDateRange($request->date, $project);


        DB::transaction(function () use ($request, &$timesheet) {
            $timesheet = Timesheet::create([
                'task_name' => $request->taskname,
                'date' => $request->date,
                'hours' => $request->hours,
                'user_id' => $request->userId,
                'project_id' => $request->projectId,
            ]);
        });

        if (is_null($timesheet)) {
            throw new \Exception('Failed to create the timesheet.');
        }

        return $timesheet->refresh()->load(['user', 'project', 'project.department', 'project.status']);
    }

    public function updateFromRequest($request, $id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            throw new \Exception('Timesheet not found.', 422);
        }

        $projectService = new ProjectService();
        $projectService->checkIfUserAssignedToProject($request->userId, $request->projectId);

        $project = Project::find($request->projectId);
        if (!$project) {
            throw new \Exception('Project not found.', 422);
        }

        $projectService->checkIfDateWithinProjectDateRange($request->date, $project);

        DB::transaction(function () use ($request, $timesheet) {
            $timesheet->update([
                'task_name' => $request->taskname,
                'date' => $request->date,
                'hours' => $request->hours,
                'user_id' => $request->userId,
                'project_id' => $request->projectId,
            ]);
        });

        return $timesheet->refresh()->load(['user', 'project', 'project.department', 'project.status']);
    }

    public function delete($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            throw new \Exception('Timesheet not found.', 422);
        }

        $timesheet->delete();
    }
}
