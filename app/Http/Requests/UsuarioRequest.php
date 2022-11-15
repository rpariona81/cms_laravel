<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Determina si el usuario esta autorizado a hacer este request
     * 
     * @return bool
     */
    public function authorize()
    {
        //return false;
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     * Obtiene las reglas de validacion para este request
     *
     * @return array
     */
    public function rules(Request $request)
    {
        //Nombre requerido y máximo 255 caracteres
        //Email requerido, válido, único en la tabla usuarios y máximo 255 caracteres
        $rules = [
            'nombre' => 'required|max:255',
            'email' => 'required|regex:/^.+@.+$/i|unique:usuarios, email,'.$request->id.'|max:255',
        ];

        //Si estoy cambiando la clave (o es nuevo), password requerido y entre 8 y 16 caracteres
        if($request->cambiar_clave){
            $rules['password'] = 'required|min:8|max:16';
        };

        return $rules;
    }
}
