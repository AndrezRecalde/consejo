<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            /* 'id'            => 'required', */
            'dni'           =>  'required',
            'avatar'        =>  [$this->route('users') ? 'nullable' : 'required', 'mimes:png,jpg,jpeg'],
            'first_name'    =>  'required',
            'last_name'     =>  'required',
            'phone'         =>  '',
            'email'         =>  'required',

            /* 'user_id'       =>  'required', */
            'canton_id'     =>  'required',
            'parroquia_id'  =>  'required',
            'roles'         =>  'required'
        ];

        if($this->filled('password'))
        {
            $rules['password'] = ['confirmed', 'min:6'];
        }
        return $rules;
    }

    public function messages()
    {
        return [
        'dni.unique' => 'Ya existe el DNI',
        'email.unique' => 'Ya existe el email',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }

}
