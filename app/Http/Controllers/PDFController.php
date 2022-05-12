<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veedor;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function getUsers()
    {
        $users  =   User::with(['canton','parroquia','roles'])->get();
        // ->join('parroquias as p', 'users.parroquia_id', '=', 'p.id')
        // ->select('users.*', 'p.nombre_parroquia')
        // ->get();

        $pdf    =   PDF::loadView('pdf.users.all', ['users' => $users]);
        // $pdf->setPaper('a4', 'landscape')->download('distrib-usuarios.pdf');
        return  $pdf->setPaper('a4', 'landscape')->stream('distrib-usuarios.pdf');
    }

    public function getVeedores()
    {
        //$veedores   =   Veedor::all();
        $veedores = DB::table('veedores as v')
        ->join('users', 'users.id', '=', 'v.user_id')
        ->join('parroquias as p', 'v.parroquia_id', '=', 'p.id')
        ->join('recintos as r', 'v.recinto_id', '=', 'r.id')
        ->select('v.*', 'users.first_name as user' ,'p.nombre_parroquia', 'r.nombre_recinto')
        ->get();
        $pdf        =   PDF::loadView('pdf.veedores.all', ['veedores' => $veedores]);
        return $pdf->setPaper('a4', 'landscape')->stream('distrib-veedores.pdf');
    }


    public function getVeedoresWithCoord(User $user)            //Lo exporta solo los Coordinadores
    {
        $veedores = DB::table('veedores as v')
        ->select(DB::raw('v.dni, CONCAT(v.first_name, v.last_name) as nombres, c.nombre_canton as canton,
                        r.nombre_recinto as origen, re.nombre_recinto as trabajo, v.phone, v.email,
                        CONCAT(u.first_name, u.last_name) as responsable'))
        ->join('users as u', 'v.user_id', 'u.id')
        ->join('parroquias as p', 'v.parroquia_id', 'p.id')
        ->join('cantones as c', 'c.id', 'p.canton_id')
        ->join('recintos as r', 'v.recinto_id', 'r.id')
        ->join('recintos as re', 'v.recinto__id', 're.id')
        ->where('v.user_id', '=', $user->id)
        ->get();

        $pdf    = PDF::loadView('pdf.veedores.with', ['veedores' => $veedores]);
        return $pdf->setPaper('a4','landscape')->stream('distrib-veedoreswith.pdf');

    }


    public function getVeedoresWithParroquia(User $user)                // Lo pueden exportar los Supervisores y Administradores
    {
        $veedores = DB::table('veedores as v')
        ->select(DB::raw('v.* , u.first_name, u.last_name, p.nombre_parroquia'))
        ->join('users as u', 'v.user_id', 'u.id')                       //Responsable Coordinador
        ->join('parroquias as p', 'u.parroquia_id', 'p.id')
        ->where('u.parroquia_id', $user->parroquia_id)
        ->get();

        $users = DB::table('users')                                     //Responsable Supervisor
        ->select(DB::raw('users.first_name, users.last_name'))
        ->join('users as u', 'users.id', 'u.user_id')
        ->where('u.id', $user->id)
        ->first();

        $pdf    =   PDF::loadView('pdf.veedores.parroquias', ['veedores' => $veedores, 'users' => $users]);
        return $pdf->setPaper('a4', 'landscape')->stream('distrib-veedoresParroquias.pdf');
    }

    public function getSupervisores()                       //Lo pueden visualizar los Admins
    {
        $supervisores = User::select(DB::raw("users.*, r.name as role"))->with(['parroquia'])
                        ->join('model_has_roles as mhr', 'mhr.model_id', 'users.id')
                        ->join('roles as r', 'r.id', 'mhr.role_id')
                        ->where('r.name', 'Supervisor')
                        ->get();
        $pdf = PDF::loadView('pdf.users.supervisores.all', ['supervisores' => $supervisores]);

        return $pdf->setPaper('a4', 'landscape')->stream('supervisores.pdf');
    }

    public function getCoordinadores()                      // Lo pueden visualizar los Admins
    {
        $coordinadores = User::select(DB::raw("users.*, r.name as role"))->with(['parroquia'])
                        ->join('model_has_roles as mhr', 'mhr.model_id', 'users.id')
                        ->join('roles as r', 'r.id', 'mhr.role_id')
                        ->where('r.name', 'Coordinador')
                        ->get();
        $pdf = PDF::loadView('pdf.users.coordinadores.all', ['coordinadores' => $coordinadores]);

        return $pdf->setPaper('a4', 'landscape')->stream('coordinadores.pdf');
    }
}
