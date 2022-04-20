<?php

namespace App\Services;

use App\Models\Credentials\Credential;
use Illuminate\Support\Facades\Auth;

class CredentialService
{
    public static function encryptArray(array $credentials): array
    {
        return collect($credentials)->mapWithKeys(function ($item, $key) {
            return [$key => encrypt($item)];
        })->toArray();
    }

    public static function decryptArray(array $credentials): array
    {
        return collect($credentials)->mapWithKeys(function ($item, $key) {
            return [$key => decrypt($item)];
        })->toArray();
    }

    public function storeCredential(string $type, array $credentials, string $name, string|null $description)
    {
        return Credential::query()->create([
            'name' => $name,
            'description' => $description,
            'credentials_json' => $this->encryptArray($credentials),
            'created_by' => Auth::user()?->id,
            'type' => $type,
        ]);
    }
}
