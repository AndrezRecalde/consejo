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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $veedores = DB::select('CALL view_veedores()');

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
            return ['error' => 'request must be an array'];
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
            'imagen_frontal'    =>  'required|mimes:png,jpg,jpeg',
            'imagen_reverso'    =>  'required|mimes:png,jpg,jpeg'
        ];

        try {
            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return [
                    'status' => 'Error',
                    'errors' => $validator->errors()->all()
                ];
            }

            $veedor = Veedor::create($request->all());

            $veedor->imagen_frontal = $request->file('imagen_frontal');
            $veedor->imagen_reverso = $request->file('imagen_reverso');

            $filename_f = $veedor->imagen_frontal->getClientOriginalName();
            $filename_r = $veedor->imagen_reverso->getClientOriginalName();

            $save_path = storage_path('app/public') . '/veedores/dni/' . $veedor->dni . '/upload/imagenes/';
            $public_path_f = '/veedores/dni/' . $veedor->dni . '/upload/imagenes/' . $filename_f;
            $public_path_r = '/veedores/dni/' . $veedor->dni . '/upload/imagenes/' . $filename_r;

            File::makeDirectory($save_path, $mode = 0755, true, true);
            Image::make($veedor->imagen_frontal)->save($save_path . $filename_f);
            Image::make($veedor->imagen_reverso)->save($save_path . $filename_r);

            $veedor->imagen_frontal = $public_path_f;
            $veedor->imagen_reverso = $public_path_r;

            $veedor->save();
            return ['status' => 'success'];
        } catch (\Exception $e) {
            \Log::info('Error creating user: ' . $e);
            return \Response::json(['status' => 'Error'], 500);
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
            return response()->json(['status' => 'sucess', 'veedor' => $veedor]);
        } else {
            return response()->json(['status' => 'Failed, El usuario no existe']);
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
                if ($request->hasFile('imagen_frontal') || $request->hasFile('imagen_reverso')) {
                    $filename_f = $veedor->imagen_frontal;
                    $filename_r = $veedor->imagen_reverso;

                    if ($filename_f) {
                        Storage::disk('public')->delete($filename_f);
                    } else if ($filename_r) {
                        Storage::disk('public')->delete($filename_r);
                    } else if ($filename_f && $filename_r) {
                        Storage::disk('public')->delete($filename_f);
                        Storage::disk('public')->delete($filename_r);
                    }


                    $veedor->fill($request->validated());

                    $veedor->imagen_frontal = $request->file('imagen_frontal');
                    $veedor->imagen_reverso = $request->file('imagen_reverso');

                    $filename_f = $veedor->imagen_frontal->getClientOriginalName();
                    $filename_r = $veedor->imagen_reverso->getClientOriginalName();

                    $save_path = storage_path('app/public') . '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/';
                    $public_path_f = '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/' . $filename_f;
                    $public_path_r = '/veedores/dni/' . $veedor->dni . '/uploads/imagenes/' . $filename_r;

                    File::makeDirectory($save_path, $mode = 0755, true, true);
                    Image::make($veedor->imagen_frontal)->save($save_path . $filename_f);
                    Image::make($veedor->imagen_reverso)->save($save_path . $filename_r);

                    $veedor->imagen_frontal = $public_path_f;
                    $veedor->imagen_reverso = $public_path_r;

                    $res = $veedor->save();
                } else {
                    $res = $veedor->update(array_filter($request->validated()));
                }
            } else {
                return response()->json(['status' => 'Usuario no encontrado']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([$request->messages()]);
        }

        if ($res) {
            return response()->json(['status' => 'Veedor actualizado']);
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
                return response()->json(['status' => 'Eliminado']);
            } else {
                $veedor->delete();
                return response()->json(['status' => 'Eliminado']);
            }
        } else {
            return response()->json(['status' => 'El veedor no ha sido encontrado']);
        }
    }
}
