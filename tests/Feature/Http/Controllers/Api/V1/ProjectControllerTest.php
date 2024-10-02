<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Enums\ProjectStatusesEnum;
use App\Http\Resources\Project\ProjectCollection;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    //execute each test within a database transaction and rollback after each test
    use RefreshDatabase;
    private $alice;

    protected function setUp(): void
    {
        parent::setUp();
        $this->alice = $this->createRandomUser();
    }

    public function test_can_get_all_projects(): void
    {
        Sanctum::actingAs($this->alice);
        Department::factory()->has(Project::factory()->count(3)->created())->create();
        Department::factory()->has(Project::factory()->count(2)->inProgress())
            ->has(Project::factory()->done())
            ->create();
        $projects = Project::all();

        $response = $this->getJson(route('projects.index', ['pageSize' => 6]));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($projects->count(), 'data')
            ->assertJson((new ProjectCollection($projects))->response()->getData(true));
    }

    public function test_can_create_a_project()
    {
        Sanctum::actingAs($this->alice);

        $departmentId = Department::factory()->create()->id;
        $project_data = [
            'name' => 'test_reqe',
            'startDate' => '2021-05-10',
            'endDate' => '2021-05-10',
            'statusId' => ProjectStatusesEnum::CREATED,
            'departmentId' => $departmentId,
        ];

        $response = $this->postJson(route('projects.store'), $project_data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(Project::class, [
            'name' => $project_data['name'],
            'start_date' => $project_data['startDate'],
            'end_date' => $project_data['endDate'],
            'status_id' => ProjectStatusesEnum::CREATED,
            'department_id' => $departmentId,
        ]);
    }
}
