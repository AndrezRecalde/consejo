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


    /** Carga todos los usuarios */
    public function loadAllUsers()
    {
        $users = User::select(DB::raw("users.id, users.dni, users.first_name, users.last_name, users.phone, users.email,
                                         c.nombre_canton, r.name"))
            ->join("cantones as c", "c.id", "users.canton_id")
            ->join("model_has_roles as mhr", "mhr.model_id", "users.id")
            ->join("roles as r", "r.id", "mhr.role_id")
            ->orderBy("r.id", "ASC")->paginate(5);

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
            return response()->json(['status' => 'Save Success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([$request->messages()]);
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

         /** Devuelve supervisores si es Administrador, devuelve Coordinadores si tiene el role Supervisor */
        $funcionarios = DB::select('CALL sp_view_funcionarios(?)', array($request->id));

        /* Devuelve una lista de veedores si el role del usuario es COORDINADOR */
        $veedores = DB::select('CALL sp_view_veedores_with_user(?)', array($request->id));

        if ($user) {
            foreach ($user as $u) {

                if ($u->roles === 'Administrador' || $u->roles === 'Supervisor') {

                    return response()->json([
                        'status' => 'success',
                        'user' => $u,
                        'funcionarios' => $funcionarios,
                    ]);
                } else {
                    return response()->json([
                        'status' => 'success',
                        'user' => $u,
                        'funcionarios' => $veedores
                    ]);
                }
            }
        } else {
            return response()->json(['status' => 'No encontrado']);
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

        //$user = User::find($request->id);
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
                    $save_path = storage_path('app/public') . '/users/dni/' . $user->dni . '/uploads/avatar/';
                    $public_path = '/users/dni/' . $user->dni . '/uploads/avatar/' . $filename;
                    File::makeDirectory($save_path, $mode = 0755, true, true);
                    Image::make($user->avatar)->save($save_path . $filename);
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
                return response()->json(['status' => 'Usuario no encontrado']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([$request->messages()]);
        }

        if ($res) {
            return response()->json(['status' => 'Usuario actualizado']);
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
                return response()->json(['status' => 'Eliminado']);
            } else {
                $user->roles()->detach();
                $user->delete();
                return response()->json(['status' => 'Eliminado']);
            }
        } else {
            return response()->json(['status' => 'El usuario no ha sido encontrado']);
        }
    }
}
