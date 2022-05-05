<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function getPermissions()
    {
        return Permission::get(['id','name']);
    }
}
