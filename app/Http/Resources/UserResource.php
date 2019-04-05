<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'      => $this->name,
            'email'     => $this->email,
            'password'  => $this->password,
            'id'        => $this->id,
            'role_id'   => $this->role_id,
            'is_active' => $this->is_active,
            'picture'   => $this->picture,

        ];
    }
}
