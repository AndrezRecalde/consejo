<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Veedor;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Storage;

use File;
use Image;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexview(Request $request)
    {
        return view('layouts.dashboard.index');
    }

    /** Carga todos los usuarios */
    public function loadAllUsers(Request $request)
    {
        $user = \Auth::guard('api')->user();
        $users = User::select(DB::raw("users.id, users.dni, users.first_name, users.last_name, users.phone, users.email,
                                         c.nombre_canton, r.name"))
            ->join("cantones as c", "c.id", "users.canton_id")
            ->join("model_has_roles as mhr", "mhr.model_id", "users.id")
            ->join("roles as r", "r.id", "mhr.role_id");
        if ($user->hasRole('Supervisor')) {
            $users = $users->where(function($q)use($user){
                $q->where('users.user_id', $user->id)
                ->orWhere('users.id', $user->id);
            });
        }
        $users = $users->orderBy("r.id", "ASC")->get();

        return response()->json(['users' => $users]);
    }


    /** Carga todos los usuarios con la condicional de ROLES, es un SP - es lo mismo que el metodo anterior */
    public function index(Request $request)
    {
        if ($request->role_id) {

            $users = DB::select('CALL view_users(?)', array($request->role_id));
            return response()->json(['users' => $users]);
        } else {
            $users = DB::select('CALL view_users(?)', array(0));
            return response()->json(['users' => $users]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* public function create()
    {

    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /** Permite guardar el usuario */
    public function store(UserStoreRequest $request)
    {
        try {
            $user = User::create($request->validated());
            $user->assignRole($request->roles);
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Save Success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        $user = DB::select('CALL view_user(?)', array($request->id));

        if ($user) {
            foreach ($user as $u) {
                $_user = User::find($u->id);
                $u->canton_id = $_user->canton->id;
                $u->parroquia_id = $_user->parroquia->id;
                $u->rol_id = $_user->roles[0]->id;
                //$u->recinto_id = $_user->recinto->id;
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
                } else {
                    /* Devuelve una lista de veedores si el role del usuario es COORDINADOR */
                    $veedores = DB::select('CALL sp_view_veedores_with_user(?)', array($request->id));
                    return response()->json([
                        'status' => 'success',
                        'user' => $u,
                        'funcionarios' => $veedores
                    ]);
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'No encontrado']);
        }

        /* */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function edit($id)
    {

    } */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            if ($user) {
                if ($request->hasFile('avatar')) {

                    $filename = $user->avatar;

                    if ($filename) {
                        Storage::disk('public')->delete($filename);
                    }

                    $user->fill($request->validated());

                    $user->avatar = $request->file('avatar');
                    $filename = $user->avatar->getClientOriginalName();
                    $save_path = '/users/dni/' . $user->dni . '/uploads/avatar/';
                    $public_path = $save_path . $filename;
                    $path = Storage::putFileAs(
                        'public' . $save_path,
                        $user->avatar,
                        $filename
                    );
                    if (!$path) {
                        \DB::rollback();
                        return response()->json(array("status" => "error", 'message' => 'Hubo un error al actualizar'));
                    }
                    $user->avatar = $public_path;
                    $res = $user->save();
                } else {
                    $res = $user->update(array_filter($request->validated()));
                }

                $user->roles()->detach();
                if ($request->filled('roles')) {
                    $user->assignRole($request->roles);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Usuario no encontrado']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => $th->getMessage()]);
        }

        if ($res) {
            return response()->json(['status' => 'success', 'message' => 'Usuario actualizado']);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            if ($user->avatar) {
                File::deleteDirectory(storage_path('app/public') . '/users/dni/' . $user->dni);
                $user->roles()->detach();
                $user->delete();
                return response()->json(['status' => 'success', 'message' => 'Eliminado']);
            } else {
                $user->roles()->detach();
                $user->delete();
                return response()->json(['status' => 'success', 'message' => 'Eliminado']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'El usuario no ha sido encontrado']);
        }
    }
}
