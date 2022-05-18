<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use DB;
class CoordinadorController extends Controller
{

    public function detail(Request $request)
    {
        return view('layouts.dashboard.index');
    }
    public function show(Request $request)
    {
        $user = DB::select('CALL view_user(?)', array($request->id));

        if ($user) {
            foreach ($user as $u) {
                $_user = User::find($u->id);
                $u->canton_id = $_user->canton->id;
                $u->parroquia_id = $_user->parroquia->id;
                $u->rol_id = $_user->roles[0]->id;
                if($u->roles === 'Administrador'){
                    /* Devuelve una lista de supervisores si el role del usuario es ADMINISTRADOR */
                    $supervisores = DB::select('CALL sp_view_supervisores');
                    return response()->json([
                        'status' => 'success',
                        'user' => $u,
                        'funcionarios' => $supervisores,
                    ]);
                }else if($u->roles === 'Supervisor'){
                    /** Devuelve supervisores si es Administrador, devuelve Coordinadores si tiene el role Supervisor */
                    $funcionarios = DB::select('CALL sp_view_funcionarios(?)', array($request->id));
                    return response()->json([
                        'status' => 'success',
                        'user' => $u,
                        'funcionarios' => $funcionarios,
                    ]);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'No encontrado']);
        }
    }
}