<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\StoreTimesheetRequest;
use App\Http\Requests\Timesheet\UpdateTimesheetRequest;
use App\Http\Resources\Timesheet\TimesheetCollection;
use App\Http\Resources\Timesheet\TimesheetResource;
use App\Services\TimesheetService;

class TimesheetController extends Controller
{
    public function index(TimesheetService $timesheetService)
    {
        $timesheets = $timesheetService->getTimesheets(
            filters: request()->all(),
            pageSize: request()->pageSize ?? config('meta.pagination.page_size')
        );

        return new TimesheetCollection($timesheets);
    }

    public function show(TimesheetService $timesheetService, $id)
    {
        try {
            $timesheet = $timesheetService->getTimesheet($id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return new TimesheetResource($timesheet);
    }

    public function store(StoreTimesheetRequest $storeTimesheetRequest, TimesheetService $timesheetService)
    {
        try {
            $timesheet = $timesheetService->createFromRequest($storeTimesheetRequest);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseCreated(new TimesheetResource($timesheet));
    }

    public function update(UpdateTimesheetRequest $updateTimesheetRequest, TimesheetService $timesheetService, $id)
    {
        try {
            $timesheet = $timesheetService->updateFromRequest($updateTimesheetRequest, $id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseOk(new TimesheetResource($timesheet));
    }

    public function destroy(TimesheetService $timesheetService, $id)
    {
        try {
            $timesheetService->delete($id);
        } catch (\Exception $e) {
            abort($e->getCode(), $e->getMessage());
        }

        return $this->responseDeleted();
    }
}
