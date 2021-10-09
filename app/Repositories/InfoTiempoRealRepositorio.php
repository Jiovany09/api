<?php

namespace App\Repositories;

use App\Helpers\JwtAuth;
use App\Models\Contenedores;
use App\Models\Generadores;
use App\Services\FirebaseService;

class InfoTiempoRealRepositorio
{
    protected $service;
    protected $dataBase;
    protected $collection = '/info_tiempo_real';
    public function __construct()
    {
        $this->service = new FirebaseService;
        $this->dataBase = $this->service->db;
    }

    public function listInfoTiempoRealGenerador($id, $hash)
    {
        if ($this->headerToken($hash)) {
            return response()->json($this->findGeneradorReal(0 + $id));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listInfoTiempoRealContenedor($id, $hash)
    {
        if ($this->headerToken($hash)) {
            return response()->json($this->findContenedorReal(0 + $id));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function createInfoGenerador($serial, $energia)
    {
        $info = $this->findGenerador($serial);
        $createInfo = $this->findGeneradorReal($info->id);
        if ($createInfo) {
            $_id = $createInfo['_id'];
            $createInfo['energia'] = $energia;
            $this->dataBase->getReference($this->collection.'/generadores'.'/'.$_id)->update($createInfo);

            return response()->json($createInfo);
        } else {
            $uniqId = uniqid();
            $infoTiempoReal['_id'] = $uniqId;
            $infoTiempoReal['generador_id'] = $info->id;
            $infoTiempoReal['energia'] = $energia;
            $this->dataBase->getReference($this->collection.'/generadores'.'/'.$uniqId)->set($infoTiempoReal);

            return response()->json($infoTiempoReal);
        }
    }

    public function createInfoContenedor($serial, $energia)
    {
        $info = $this->findContenedor($serial);
        $createInfo = $this->findContenedorReal($info->id);
        if ($createInfo) {
            $_id = $createInfo['_id'];
            $createInfo['energia'] = $energia;
            $this->dataBase->getReference($this->collection.'/contenedores'.'/'.$_id)->update($createInfo);

            return response()->json($createInfo);
        } else {
            $uniqId = uniqid();
            $infoTiempoReal['_id'] = $uniqId;
            $infoTiempoReal['contenedor_id'] = $info->id;
            $infoTiempoReal['energia'] = $energia;
            $this->dataBase->getReference($this->collection.'/contenedores'.'/'.$uniqId)->set($infoTiempoReal);

            return response()->json($infoTiempoReal);
        }
    }

    public function aumentarUsuarioGenerador($serial, $hash)
    {
        if ($this->headerToken($hash)) {
            $generador = $this->findGenerador($serial);
            $generador->contador = $generador->contador + 1;
            $generador->save();

            return response()->json($generador);
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function decrementarUsuarioGenerador($serial, $hash)
    {
        if ($this->headerToken($hash)) {
            $generador = $this->findGenerador($serial);
            $generador->contador = $generador->contador - 1;
            $generador->save();

            return response()->json($generador);
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function aumentarUsuarioContenedor($serial, $hash)
    {
        if ($this->headerToken($hash)) {
            $contenedor = $this->findContenedor($serial);
            $contenedor->contador = $contenedor->contador + 1;
            $contenedor->save();

            return response()->json($contenedor);
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function decrementarUsuarioContenedor($serial, $hash)
    {
        if ($this->headerToken($hash)) {
            $contenedor = $this->findContenedor($serial);
            $contenedor->contador = $contenedor->contador - 1;
            $contenedor->save();

            return response()->json($contenedor);
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function findGeneradorReal($id)
    {
        $data = $this->dataBase->getReference($this->collection.'/generadores')->getValue();
        $info = [];
        if ($data) {
            foreach ($data as $clave => $valor) {
                if ($valor['generador_id'] == $id) {
                    array_push($info, $valor);
                    return $info[0];
                }
            }
        }
        return $info;
    }

    public function findGenerador($serial)
    {
        return Generadores::where('serial', '=', $serial)->first();
    }

    public function findContenedorReal($id)
    {
        $data = $this->dataBase->getReference($this->collection.'/contenedores')->getValue();
        $info = [];
        if ($data) {
            foreach ($data as $clave => $valor) {
                if ($valor['contenedor_id'] == $id) {
                    array_push($info, $valor);
                    return $info[0];
                }
            }
        }
        return $info;
    }

    public function findContenedor($serial)
    {
        return Contenedores::where('serial', '=', $serial)->first();
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
}
