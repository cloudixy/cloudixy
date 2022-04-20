<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRolesAndPermissions extends Command
{
    public const PERMISSIONS = [
        'view users',
        'create users',
        'view credentials',
        'create credentials',
    ];
    public const ROLES = [
        'owner' => [
            'view users',
            'create users',
            'view credentials',
            'create credentials',
        ],
        'developer' => [
            'view users',
            'view credentials',
        ],
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:roles-and-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the needed roles and permissions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Creating permissions');
        foreach (self::PERMISSIONS as $permission) {
            Permission::query()->updateOrCreate([
                'name' => $permission,
            ]);
        }
        $this->info('Permissions created');

        $this->info('Creating roles');
        foreach (self::ROLES as $role => $permissions) {
            $roleModel = Role::query()->updateOrCreate([
                'name' => $role,
            ]);
            $roleModel->syncPermissions($permissions);
        }
        $this->info('Roles created');
        return 0;
    }
}
