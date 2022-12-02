<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     *
     * @return array
     */
    public function rules(Request $request)
    {
        //Titulo requerido, máximo 32 caracteres
        //Slug máximo 36 caracteres (no requerido porque se generaria solo)
        //Entradilla máximo 128 caracteres (no requerida)
        $rules = [
            'titulo' => 'required|max:32',
            'slug' => 'max:36',
            'entradilla' => 'max:128',
        ];

        return $rules;
    }
}
