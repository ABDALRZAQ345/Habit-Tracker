<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HabitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $habit = $this->resource;
        $data = parent::toArray($request);
        $data['days'] = $habit->getDays();

        return $data;
    }
}
