<?php

namespace App\Http\Controllers\Perfil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class PerfilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        // \Auth::logout();\Session::flush();
        // return redirect('/');
        return view('layouts.dashboard.index');
    }
}
