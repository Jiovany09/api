<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class DetallesContenedoresValidations
{
    public function createDetalleContenedor($request)
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|exists:contenedores,serial|string|max:20',
            'energia' => 'required|numeric'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusError();
            return response()->json(compact('data','error'));
        }
    }

    public function statusError()
    {
        $data = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'Detalle del contenedor no registrado'
        );

        return $data;
    }
}