<?php

namespace App\Validations;

use Illuminate\Support\Facades\Validator;

class DetallesGeneradoresValidations
{
    public function createDetalle($request)
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|exists:generadores,serial|string|max:20',
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
            'message' => 'Detalle del generador no registrado'
        );

        return $data;
    }
}