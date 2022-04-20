<?php

namespace App\Services\API;

use App\Models\Credentials\GitlabCredential;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GitlabAPI
{
    private PendingRequest $request;
    private GitlabCredential $gitlabCredential;

    public function __construct(GitlabCredential|null $gitlabCredential)
    {
        if (! is_null($gitlabCredential)) {
            $this->setGitlabCredential($gitlabCredential);
        }
    }

    public function setGitlabCredential(GitlabCredential $gitlabCredential)
    {
        $this->gitlabCredential = $gitlabCredential;
        $this->setupRequest();
    }

    public function getUsers($filters = [])
    {
        return $this->request->get('users?' . http_build_query($filters))->json();
    }

    public function getUser($gitlabId)
    {
        return $this->request->get("users/{$gitlabId}")->json();
    }

    private function setupRequest()
    {
        $this->request = Http::baseUrl($this->gitlabCredential->getApiUrl())
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->gitlabCredential->getAccessTokenSecret(),
            ])
            ->acceptJson();
    }
}
