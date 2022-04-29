<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class VeedorUpdateRequest extends FormRequest
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
        $rules = [
            'dni'           =>  'required',
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'phone'         =>  'required',
            'email'         =>  'required',
            'observacion'   =>  '',
            'parroquia_id'  =>  'required',   //Parroquia donde trabaja
            'recinto_id'    =>  'required',  //Recinto de donde es originario
            'recinto__id'   =>  'required',  //Recinto en donde trabaja
            'imagen_frontal'    =>  [$this->route('veedores') ? 'nullable' : 'required', 'mimes:png,jpg,jpeg'],
            'imagen_reverso'    =>  [$this->route('veedores') ? 'nullable' : 'required', 'mimes:png,jpg,jpeg']
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'dni.required' => 'El DNI es obligatorio',
            'dni.unique'   =>  'El DNI ya existe',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        /* $errors = (new ValidationException($validator))->errors(); */
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }
}
