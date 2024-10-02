<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\Project\ProjectResource;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function index(ProjectService $projectService)
    {
        $projects = $projectService->getProjects(
            filters: request()->all(),
            pageSize: request()->pageSize ?? config('meta.pagination.page_size')
        );

        return new ProjectCollection($projects);
    }

    public function show(ProjectService $projectService, $id)
    {
        try {
            $project = $projectService->getProject($id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return new ProjectResource($project);
    }

    public function store(StoreProjectRequest $storeProjectRequest, ProjectService $projectService)
    {
        try {
            $project = $projectService->createFromRequest($storeProjectRequest);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseCreated(new ProjectResource($project));
    }

    public function update(UpdateProjectRequest $updateProjectRequest, ProjectService $projectService, $id)
    {
        try {
            $project = $projectService->updateFromRequest($updateProjectRequest, $id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseOk(new ProjectResource($project));
    }

    public function destroy(ProjectService $projectService, $id)
    {
        try {
            $projectService->delete($id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseDeleted();
    }
}
