<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
             
            'codigo' => 'required',
            'codigo_de_barras' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'familia_producto' => 'required',
            'precio' => 'required',
            'stock' => 'required'
        ];
    }
}
