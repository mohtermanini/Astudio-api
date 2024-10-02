<?php

namespace App\Http\Requests\Timesheet;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimesheetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'taskname' => ['required', 'string', 'max:1000'],
            'date' => ['required', 'date'],
            'hours' => ['required', 'numeric', 'min:0'],
            'projectId' => ['required', 'integer', 'exists:projects,id'],
            'userId' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
