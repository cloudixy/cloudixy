<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MetaController extends Controller
{
    public function permissionIndex(){
        return PermissionResource::collection(Permission::all());
    }

    public function roleIndex(){
        return PermissionResource::collection(Role::all());
    }
}
