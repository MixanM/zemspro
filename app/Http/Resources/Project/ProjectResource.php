<?php

namespace App\Http\Resources\Project;

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
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' =>$this->title,
            'user_name'=>$this->user_name,
            'tasks_status_2'=>$this->tasks_status_2,
            'total_tasks'=>$this->total_tasks,
            'total_time'=>$this->total_time,
            'status_title' => $this->status_title,
            'created_at' => $this->created_at->format('d-m-Y H:m'),
        ];
    }
}
