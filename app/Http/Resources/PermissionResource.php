<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(\Illuminate\Http\Request $request): array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
