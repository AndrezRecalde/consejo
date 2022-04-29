<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeedorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dni'           =>  '',
            'first_name'    =>  '',
            'last_name'     =>  '',
            'phone'         =>  '',
            'email'         =>  '',
            'observacion'   =>  '',
            'parroquia_id'  =>  '',   //Parroquia donde trabaja
            'recinto_id'    =>  '',  //Recinto de donde es originario
            'recinto__id'   =>  '',  //Recinto en donde trabaja
            'imagen_frontal'    =>  '',
            'imagen_reverso'    =>  ''
        ];
    }


    public function messages()
    {
        return [
        'dni.required'  =>  'El campo DNI es requerido',
        'dni.unique'    =>  'El DNI ya existe',
        'first_name'    =>  'Los nombres completos es obligatorio',
        'last_name'     =>  'Los apellidos es obligatorio',
        'phone'         =>  'El telefono es obligatorio',
        'email'         =>  'El correo electronico es obligatorio',
        'email.unique'  =>  'El email ya existe',
        'parroquia_id'  =>  'La parroquia es obligatorio',
        ];
    }

}
