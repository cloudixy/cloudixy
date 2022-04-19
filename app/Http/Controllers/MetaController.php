<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function permissionIndex()
    {
        return PermissionResource::collection(Permission::all());
    }

    public function roleIndex()
    {
        return PermissionResource::collection(Role::all());
    }
}
