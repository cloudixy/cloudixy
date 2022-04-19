<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCredentialRequest;
use App\Http\Resources\CredentialResource;
use App\Models\Credentials\Credential;
use App\Services\CredentialService;

class CredentialController extends Controller
{
    public function __construct(private CredentialService $credentialService)
    {
    }

    public function index()
    {
        return CredentialResource::collection(Credential::all());
    }

    public function store(StoreCredentialRequest $request){
        $data = $request->validated();
        $credentials = $this->credentialService->storeCredential(
            $data["type"],
            $data["credentials"],
            $data["name"],
            $data["description"]
        );

        return CredentialResource::make($credentials);
    }
}
