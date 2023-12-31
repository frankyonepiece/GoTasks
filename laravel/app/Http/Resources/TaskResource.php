<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $completed = strlen($this->completed_at) > 0;
        return [
            'id'=> $this->id,
            "title" => $this->title,
            "description" => $this->description,
            'completed' => $completed,
        ];
    }
}
