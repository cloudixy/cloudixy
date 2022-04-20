<?php

namespace App\Models\Credentials;

use App\Services\CredentialService;
use Illuminate\Support\Arr;
use Parental\HasParent;

class GitlabCredential extends Credential
{
    use HasParent;
    protected $table = 'credentials';

    public function getAccessTokenSecret(): string
    {
        return Arr::get(CredentialService::decryptArray($this->credentials_json), 'accessTokenSecret');
    }

    public function getApiUrl(): string
    {
        return Arr::get(CredentialService::decryptArray($this->credentials_json), 'url', 'https://gitlab.com/api/v4/');
    }
}
