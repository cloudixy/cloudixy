<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\UserInviteMail;
use App\Models\Credentials\Credential;
use App\Models\Credentials\GitlabCredential;
use App\Models\User;
use App\Services\API\GitlabAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(array $data)
    {
        $password = self::generatePassword();
        $user = User::query()->create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => bcrypt($password),
            'invited_by' => Auth::user()?->id,
            'metadata' => [
                'gitlabUsername' => $data['gitlabUsername'],
            ],
        ]);

        $user->syncRoles($data['roles']);
        $csv = $this->createNewUserCsv($user, $password);
        Mail::to($data['email'])->send(new UserInviteMail($csv));
        return $user;
    }

    public function updateUser(User $user, $data)
    {
        $user->update([
            'email' => $data['email'],
            'name' => $data['name'],
        ]);
        $user->syncRoles($data['roles']);
        return $user;
    }

    private static function generatePassword(): string
    {
        return Str::random();
    }

    private function createNewUserCsv(User $user, string $password)
    {
        return "{$user->email},{$password}";
    }

    public function syncUser(User $user, string|int $credentialId){
        /* @var Credential $credential */
        $credential = Credential::query()->find($credentialId);
        switch ($credential->type){
            case "gitlab": $this->syncGitlab($user, $credential);
        }
    }

    private function syncGitlab(User $user, Credential $credential){
        /* @var GitlabCredential $gitlabCredential */
        $gitlabCredential = GitlabCredential::query()->find($credential->id);
        $gitlabApi = new GitlabAPI($gitlabCredential);
        $metadata = !is_null($user->metadata) ? $user->metadata : [];

        $gitlabUsername = Arr::get($metadata, "gitlabUsername", null);
        if(is_null($gitlabUsername)) return;

        $gitlabId = Arr::get($gitlabApi->getUsers(["username" => $gitlabUsername]), "0.id", null);
        if(!is_null($gitlabId)){
            $user->gitlab_id = $gitlabId;
            $metadata["gitlabData"] = $gitlabApi->getUser($gitlabId);
            $user->metadata = $metadata;
            $user->save();
        }
    }
}
