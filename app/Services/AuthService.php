<?php

namespace App\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use DB;
class AuthService
{
    public function __construct()
    { }

    public function login($request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'dni' => 'required|string|max:15',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);
    
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'message' => $validator->errors()->all()
                ];
            }
            $credentials = request(['dni', 'password']);
    
            if (!\Auth::attempt($credentials))
                return response()->json([
                    'status' => 'error',
                    'message' => __('auth.failed')
                ], 401);
    
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
    
            $token = $tokenResult->token;
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();
    
            //$request->id = $user->id;
            $show_user = json_decode(json_encode($this->showUser($user->id)),true);
            $response = $show_user["user"];
            $response["token"] = 'Bearer ' . $tokenResult->accessToken;
            $response["expires_at"] = Carbon::parse($token->expires_at)->toDateTimeString();
            return response()->json($response);
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => 'Hubo un error al loguearse, intente nuevamente mas tarde.'
            ];
        }
    }
    public function showUser($user_id)
    {
        $user = DB::select('CALL view_user(?)', array($user_id));

        /** Devuelve supervisores si es Administrador, devuelve Coordinadores si tiene el role Supervisor */
        $funcionarios = DB::select('CALL sp_view_funcionarios(?)', array($user_id));

        /* Devuelve una lista de veedores si el role del usuario es COORDINADOR */
        $veedores = DB::select('CALL sp_view_veedores_with_user(?)', array($user_id));

        if ($user) {
            foreach ($user as $u) {
                if ($u->roles === 'Administrador' || $u->roles === 'Supervisor') {
                    return [
                        'user' => $u,
                        'funcionarios' => $funcionarios,
                    ];
                } else {
                    return [
                        'user' => $u,
                        'funcionarios' => $veedores
                    ];
                }
            }
        } else {
            return ['status' => 'No encontrado'];
        }
        /* */
    }
    public function logoutweb($request)
    {
        foreach (\Auth::user()->tokens as $key => $value) {
            $value->revoke();
        }
        \Session::flush();
        \Auth::logout();
        return redirect('/');
    }
    public function logoutapi($request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => __('auth.successlogout')
        ]);
    }
}
