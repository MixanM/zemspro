<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'title'=>$this->title,
            'created_at'=>$this->created_at->format('d-m-Y H:m'),
            'progress'=>$this->progress,
            'difference'=>$this->difference,
            'overview'=>$this->overview,
            'id'=>$this->id,
            'author'=>$this->author,
            'performer'=>$this->performer,
            'status_title'=>$this->status_title,
            'project_title'=>$this->project_title,
            'project_id'=>$this->project_id,

        ];
    }
}
