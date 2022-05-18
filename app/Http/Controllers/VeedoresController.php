<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeedorStoreRequest;
use App\Models\Veedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;
use File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VeedorUpdateRequest;

use function Spatie\Ignition\ErrorPage\report;

class VeedoresController extends Controller
{
    public function indexview(Request $request)
    {
        return view('layouts.dashboard.index');
    }
    public function detail(Request $request)
    {
        return view('layouts.dashboard.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::guard('api')->user();
        $veedores = DB::select('CALL view_veedores(?)', array($user->id));

        if ($veedores) {
            return response()->json(['status' => 'success', 'veedores' => $veedores]);
        } else {
            return response()->json(['status' => '[FAILED] Ups!, Algo salio mal',]);
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
    public function store(Request $request)
    {

        if (!is_array($request->all())) {
            return ['status' => 'error','message'=>'request must be an array'];
        }

        $rules = [
            'dni'           =>  'required|unique:veedores',
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'phone'         =>  'required',
            'email'         =>  'required|unique:veedores',
            'observacion'   =>  '',
            'parroquia_id'  =>  'required',   //Parroquia donde trabaja
            'recinto_id'    =>  'required',  //Recinto de donde es originario
            'recinto__id'   =>  'required',  //Recinto en donde trabaja
            // 'imagen_frontal'    =>  'required|mimes:png,jpg,jpeg',
            // 'imagen_reverso'    =>  'required|mimes:png,jpg,jpeg'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return [
                    'status' => 'Error',
                    'message' => $validator->errors()->all()
                ];
            }

            $veedor = Veedor::create($request->all());
            if($request->file('imagen_frontal')){
                $veedor->imagen_frontal = $request->file('imagen_frontal');
                $filename_f = $veedor->imagen_frontal->getClientOriginalName();
                //$save_path = storage_path('app/public') . '/veedores/dni/' . $veedor->dni . '/upload/imagenes/';
                $save_path =  '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/';
                // $public_path_f = '/veedores/dni/' . $veedor->dni . '/upload/imagenes/' . $filename_f;
                // $public_path_r = '/veedores/dni/' . $veedor->dni . '/upload/imagenes/' . $filename_r;
                $public_path_f = $save_path . $filename_f;
                $path = Storage::putFileAs(
                    'public'.$save_path,
                    $veedor->imagen_frontal,
                    $filename_f
                );
                if (!$path) {
                    \DB::rollback();
                    return response()->json(array("status" => "error",'message'=>'Hubo un error al actualizar'));
                }
                $veedor->imagen_frontal = $public_path_f;
            }
            if($request->file('imagen_reverso')){
                $veedor->imagen_reverso = $request->file('imagen_reverso');
                $filename_r = $veedor->imagen_reverso->getClientOriginalName();
                $save_path =  '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/';
                $public_path_r = $save_path . $filename_r;
                $path = Storage::putFileAs(
                    'public/'.$save_path,
                    $veedor->imagen_reverso,
                    $filename_r
                );
                if (!$path) {
                    \DB::rollback();
                    return response()->json(array("status" => "error",'message'=>'Hubo un error al actualizar'));
                }
                $veedor->imagen_reverso = $public_path_r;
            }

            $veedor->save();
            return ['status' => 'success','message'=>'veedor registrado'];
        } catch (\Throwable $e) {
            \Log::info('Error creating user: ' . $e);
            return \Response::json(['status' => 'error','message'=>$e->getMessage()], 500);
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
        $veedor = DB::select('CALL sp_view_veedores(?)', array($request->id));
        if ($veedor) {
            return response()->json(['status' => 'sucess', 'veedor' => $veedor[0]]);
        } else {
            return response()->json(['status' => 'error','message'=>'Failed, El usuario no existe']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VeedorUpdateRequest $request, Veedor $veedor)
    {
        try {
            if ($veedor) {
                if($request->hasFile('imagen_frontal') || $request->hasFile('imagen_reverso')){
                    if ($request->hasFile('imagen_frontal')) {
                        $filename_f = $veedor->imagen_frontal;
    
                        if ($filename_f) {
                            Storage::disk('public')->delete($filename_f);
                        }
    
                        $veedor->fill($request->validated());
                        $veedor->imagen_frontal = $request->file('imagen_frontal');
                        $filename_f = $veedor->imagen_frontal->getClientOriginalName();
                        $save_path = '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/';
                        $public_path_f = $save_path . $filename_f;
                        $path = Storage::putFileAs(
                            'public'.$save_path,
                            $veedor->imagen_frontal,
                            $filename_f
                        );
                        if (!$path) {
                            \DB::rollback();
                            return response()->json(array("status" => "error",'message'=>'Hubo un error al actualizar'));
                        }
                        // File::makeDirectory($save_path, $mode = 0755, true, true);
                        // Image::make($veedor->imagen_frontal)->save($save_path . $filename_f);
                        // Image::make($veedor->imagen_reverso)->save($save_path . $filename_r);
                        $veedor->imagen_frontal = $public_path_f;
                    }
                    if($request->hasFile('imagen_reverso')){
                        $filename_r = $veedor->imagen_reverso;
                        if ($filename_r) {
                            Storage::disk('public')->delete($filename_r);
                        }
                        $veedor->fill($request->validated());
                        $veedor->imagen_reverso = $request->file('imagen_reverso');
                        $filename_r = $veedor->imagen_reverso->getClientOriginalName();
                        $save_path = '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/';
                        $public_path_r = $save_path . $filename_r;
                        $path = Storage::putFileAs(
                            'public'.$save_path,
                            $veedor->imagen_reverso,
                            $filename_r
                        );
                        if (!$path) {
                            \DB::rollback();
                            return response()->json(array("status" => "error",'message'=>'Hubo un error al actualizar'));
                        }
                        $veedor->imagen_reverso = $public_path_r;
                    }
                    $res = $veedor->save();
                }else {
                    $res = $veedor->update(array_filter($request->validated()));
                }
            } else {
                return response()->json(['status' => 'error','message'=>'Usuario no encontrado']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([$request->messages()]);
        }

        if ($res) {
            return response()->json(['status' => 'success','message'=>'Veedor actualizado']);
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
        $veedor = Veedor::find($request->id);

        if ($veedor) {
            if ($veedor->imagen_frontal && $veedor->imagen_reverso) {
                File::deleteDirectory(storage_path('app/public') . '/users/dni/' . $veedor->dni);
                $veedor->delete();
                return response()->json(['status' => 'success','message'=>'Eliminado']);
            } else {
                $veedor->delete();
                return response()->json(['status' => 'success','message'=>'Eliminado']);
            }
        } else {
            return response()->json(['status' => 'error','message'=>'El veedor no ha sido encontrado']);
        }
    }
}
