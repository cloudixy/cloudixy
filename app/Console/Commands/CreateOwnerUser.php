<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateOwnerUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:owner-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create main user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask('Name', 'admin');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $user->assignRole('owner');

        $this->info("User {$user->email} with ID {$user->id} created successfully");

        return 0;
    }
}
