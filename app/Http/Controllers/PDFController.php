<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function getUsers()
    {
        $users  =   User::all();
        $pdf    =   PDF::loadView('pdf.users.all', ['users' => $users]);
        return  $pdf->setPaper('a4', 'landscape')->stream('distrib-usuarios.pdf');
    }

    public function getVeedores()
    {
        $veedores   =   Veedor::all();
        $pdf        =   PDF::loadView('pdf.veedores.all', ['veedores' => $veedores]);
        return $pdf->setPaper('a4', 'landscape')->stream('distrib-veedores.pdf');
    }
}
