<?php

namespace App\Repositories;

use App\Models\Generadores;
use App\Helpers\JwtAuth;

class GeneradoresRepositorio
{
    public function createGeneradores($serial,$hash)
    {   
        if ($this->headerToken($hash)) {
            $arrayLetras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            $generador = Generadores::withTrashed()->count();
            $generadores['generador'] = 'Generador '.$arrayLetras[$generador];
            $generadores['estado'] = 0;
            $generadores['contador'] = 0;
            $generadores['serial'] = $serial;
            
            Generadores::create($generadores);
            
            $data = $this->statusSucces();
            return response()->json(compact('data','generadores'));
        } else {
            return $this->errorAuthenticate();
        }   
    }

    public function listGeneradores($hash)
    {
        if ($this->headerToken($hash)) {
            return Generadores::all();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listGeneradoresEliminate($hash)
    {
        if ($this->headerToken($hash)) {
            return Generadores::onlyTrashed()->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function editGeneradores($id,$serial,$hash)
    {
        if ($this->headerToken($hash)) {
            $generador = $this->find($id);
            $generador->serial = $serial;
            $generador->save();
        
            $data = $this->statusSuccesEdit();
            return response()->json(compact('data','generador'));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function eliminateGeneradores($id,$hash)
    {
        if ($this->headerToken($hash)) {
            $generadores = $this->find($id);
            $generadores->estado = 0;
            $generadores->save();

            return $generadores->delete();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function activarDesactivar($id,$hash)
    {
        if ($this->headerToken($hash)) {
            $generadores = $this->find($id);
            if ($generadores->estado == 1) {
                $generadores->estado = 0;
            }else {
                $generadores->estado = 1;
            }
            $generadores->save();
            return $generadores;
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function restoreGeneradores($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Generadores::onlyTrashed()->find($id)->restore();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function findProtected($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Generadores::where('id','=',$id)->first();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function find($id)
    {
        return Generadores::where('id','=',$id)->first();
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
            'message' => 'Generador registrado correctamente'
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