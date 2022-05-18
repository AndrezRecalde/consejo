<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function getRoles()
    {
        $user = \Auth::guard('api')->user();
        if($user->hasRole('Administrador')){
            return Role::get(['id','name']);
        }else if($user->hasRole('Supervisor')){
            return Role::where('name','Coordinador')->get(['id','name']);
        }
    }
}
