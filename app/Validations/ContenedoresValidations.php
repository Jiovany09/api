<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contenedores;

class ContenedoresValidations
{
    public function createContenedores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'generador_id' => 'required|exists:generadores,id|integer',
            'empleado_id' => 'required|exists:users,id|integer',
            'serial' => 'required|string|max:20|unique:contenedores'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusError();
            return response()->json(compact('data','error'));
        }
    }

    public function editContenedores(Request $request,$id)
    {
        $contenedor = Contenedores::where('id','=',$id)->first();
        if ($contenedor->serial == $request->get('serial')) {
            $validator = Validator::make($request->all(), [
                'generador_id' => 'required|exists:generadores,id|integer',
                'empleado_id' => 'required|exists:users,id|integer',
                'serial' => 'required|string|max:20'
            ]);
    
            if($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        } else {
            $validator = Validator::make($request->all(), [
                'generador_id' => 'required|exists:generadores,id|integer',
                'empleado_id' => 'required|exists:users,id|integer',
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
            'message' => 'Contenedor no registrado'
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