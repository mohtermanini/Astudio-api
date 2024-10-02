<?php

namespace App\Http\Resources\User;

use App\Enums\GendersEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
            'dob' => $this->dob,
            'gender' => $this->gender === GendersEnum::Male->value ? 'male' : 'female',
            'email' => $this->email,
        ];
    }
}
