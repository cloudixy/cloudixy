<?php

namespace App\Services;

use App\Mail\UserInviteMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(array $data){
        $password = self::generatePassword();
        $user = User::query()->create([
            "email" => $data["email"],
            "name" => $data["name"],
            "password" => bcrypt($password),
            "invited_by" => Auth::user()?->id,
            "metadata" => [
                "gitlabUsername" => $data["gitlabUsername"]
            ]
        ]);

        $user->syncRoles($data["roles"]);
        $csv = $this->createNewUserCsv($user, $password);
        Mail::to($data["email"])->send(new UserInviteMail($csv));
        return $user;
    }

    private static function generatePassword(): string
    {
        return Str::random();
    }

    private function createNewUserCsv(User $user, string $password){
        return "{$user->email},{$password}";
    }

    public function updateUser(User $user, $data){
        $user->update([
            "email" => $data["email"],
            "name" => $data["name"],
        ]);
        $user->syncRoles($data["roles"]);
        return $user;
    }
}
