<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Generadores;

class GeneradoresValidations
{
    public function createGeneradores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|string|max:20|unique:generadores'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusError();
            return response()->json(compact('data','error'));
        }
    }

    public function editGeneradores(Request $request,$id)
    {
        $generador = Generadores::where('id','=',$id)->first();
        if ($generador->serial == $request->get('serial')) {
            $validator = Validator::make($request->all(), [
                'serial' => 'required|string|max:20'
            ]);
    
            if($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        } else {
            $validator = Validator::make($request->all(), [
                'serial' => 'required|string|max:20|unique:generadores'
            ]);
    
            if($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        }
    }

    public function statusError()
    {
        $data = array(
            'status' => 'error',
            'code' => 400,
            'message' => 'Generador no registrado'
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