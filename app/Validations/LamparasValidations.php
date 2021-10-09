<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LamparasValidations
{
    public function createLampara(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contenedor_id' => 'required|exists:contenedores,id|integer'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusError();
            return response()->json(compact('data','error'));
        }
    }

    public function editLamparas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contenedor_id' => 'required|exists:contenedores,id|integer'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusEditError();
            return response()->json(compact('data','error'));
        }
    }

    public function statusError()
    {
        $data = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'Lámpara no registrada'
        );

        return $data;
    }

    public function statusEditError()
    {
        $data = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'No se editó el registro'
        );

        return $data;
    }
}