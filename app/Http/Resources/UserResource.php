<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(\Illuminate\Http\Request $request): array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'permissions' => PermissionResource::collection($this->getAllPermissions()),
            'roles' => $this->getRoleNames(),
        ];
    }
}
