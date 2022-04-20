<?php

namespace App\Http\Resources;

use App\Services\CredentialService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CredentialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'createdAt' => $this->created_at,
            'credentials' => $this->getMaskedCredentials(),
        ];
    }

    private function getMaskedCredentials()
    {
        $credentialsService = app()->make(CredentialService::class);
        $creds = $credentialsService->decryptArray($this->credentials_json);
        return collect($creds)->mapWithKeys(function ($item, $key) {
            return [$key => Str::mask($item, '*', 0, strlen($item) - 6)];
        })->toArray();
    }
}
