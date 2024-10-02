<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Department\DepartmentResource;
use App\Http\Resources\ProjectStatus\ProjectStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->whenHas('description'),
            'department' => new DepartmentResource($this->whenLoaded('department')),
            'status' => new ProjectStatusResource($this->whenLoaded('status'))
        ];
    }
}
