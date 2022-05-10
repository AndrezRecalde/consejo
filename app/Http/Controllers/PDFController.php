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
}
