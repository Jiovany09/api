<?php

namespace App\Repositories;

use App\Models\Contenedores;
use App\Helpers\JwtAuth;

class ContenedoresRepositorio
{
    public function createContenedores($empleado_id,$generador_id,$serial,$hash)
    {
        if ($this->headerToken($hash)) {
            $arrayLetras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            $contenedor = Contenedores::withTrashed()->count();
            $contenedores['contenedor'] = 'Contenedor '.$arrayLetras[$contenedor];
            $contenedores['estado'] = 0;
            $contenedores['contador'] = 0;
            $contenedores['empleado_id'] = $empleado_id;
            $contenedores['generador_id'] = $generador_id;
            $contenedores['serial'] = $serial;

            Contenedores::create($contenedores);
            
            $data = $this->statusSucces();
            return response()->json(compact('data','contenedores'));
        } else {
            return $this->errorAuthenticate();
        }  
    }

    public function listContenedores($hash)
    {
        if ($this->headerToken($hash)) {
            $contenedores = Contenedores::with('empleados','generadores')->get();

            return $contenedores->toArray();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listContenedoresEliminate($hash)
    {
        if ($this->headerToken($hash)) {
            $contenedores = Contenedores::onlyTrashed()->with('empleados','generadores')->get();

            return $contenedores->toArray();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function editContenedores($id,$empleado_id,$generador_id,$serial,$hash)
    {
        if ($this->headerToken($hash)) {
            $contenedores = $this->find($id);
            $contenedores->empleado_id = $empleado_id;
            $contenedores->generador_id = $generador_id;
            $contenedores->serial = $serial;
            $contenedores->save();

            $data = $this->statusSuccesEdit();
            return response()->json(compact('data','contenedores'));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function deleteContenedores($id,$hash)
    {
        if ($this->headerToken($hash)) {
            $contenedores = $this->find($id);
            $contenedores->estado = 0;
            $contenedores->save();

            return $contenedores->delete();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function restoreContenedores($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Contenedores::onlyTrashed()->find($id)->restore();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function activarDesactivarContenedores($id,$hash)
    {
        if ($this->headerToken($hash)) {
            $contenedores = $this->find($id);
            if ($contenedores->estado == 1) {
                $contenedores->estado = 0;
            }else {
                $contenedores->estado = 1;
            }
            $contenedores->save();
            return $contenedores;
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function findProtected($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Contenedores::where('id','=',$id)->first();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function find($id)
    {
        return Contenedores::where('id','=',$id)->first();
    }

    public function headerToken($hash)
    {
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);

        if ($checkToken) {
            return true;
        } else {
            return false;
        }
    }

    public function errorAuthenticate()
    {
        return $data = array(
            'status' => 'error',
            'message' => 'No autentificado'
        );
    }

    public function statusSucces()
    {
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Contenedor registrado correctamente'
        );

        return $data;
    }

    public function statusSuccesEdit()
    {
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Se editó correctamente'
        );

        return $data;
    }
}