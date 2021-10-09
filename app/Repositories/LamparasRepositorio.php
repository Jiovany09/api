<?php

namespace App\Repositories;

use App\Models\Lamparas;
use App\Helpers\JwtAuth;

class LamparasRepositorio
{
    public function createLampara($contenedor_id,$hash)
    {
        if ($this->headerToken($hash)) {
            $arrayLetras = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","Ñ","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            $lampara = Lamparas::withTrashed()->count();
            $lamparas['lampara'] = 'Lampara '.$arrayLetras[$lampara];
            $lamparas['contenedor_id'] = $contenedor_id;
            $lamparas['estado'] = 0;
            
            Lamparas::create($lamparas);
            
            $data = $this->statusSucces();
            return response()->json(compact('data','lamparas'));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listLamparas($hash)
    {
        if ($this->headerToken($hash)) {
            return Lamparas::with('contenedores')->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listLamparasEliminate($hash)
    {
        if ($this->headerToken($hash)) {
            return Lamparas::onlyTrashed()->with('contenedores')->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listByContainer($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Lamparas::where('contenedor_id','=',$id)->with('contenedores')->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function editLamparas($id,$contenedor_id,$hash)
    {
        if ($this->headerToken($hash)) {
            $lampara = $this->find($id);
            $lampara->contenedor_id = $contenedor_id;
            $lampara->save();
        
            $data = $this->statusSuccesEdit();
            return response()->json(compact('data','lampara'));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function deleteLamparas($id,$hash)
    {
        if ($this->headerToken($hash)) {
            $lampara = $this->find($id);
            $lampara->estado = 0;
            $lampara->save();

            return $lampara->delete();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function activarDesactivarLamparas($id,$hash)
    {
        if ($this->headerToken($hash)) {
            $lampara = $this->find($id);
            if ($lampara->estado == 1) {
                $lampara->estado = 0;
            }else {
                $lampara->estado = 1;
            }
            $lampara->save();
            return $lampara;
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function restoreLamparas($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Lamparas::onlyTrashed()->find($id)->restore();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function findProtected($id,$hash)
    {
        if ($this->headerToken($hash)) {
            return Lamparas::where('id','=',$id)->first();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function find($id)
    {
        return Lamparas::where('id','=',$id)->first();
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
            'message' => 'Lampara registrada correctamente'
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