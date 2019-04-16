<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'path'       =>$this->path,
            'body'       => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'user'       => $this->user->name,
            'user_id'    => $this->user_id,
            'task'       => $this->task->type,
            'task_id'    => $this->task_id

        ];
    }
}
