<?php

namespace App\Repositories;

use App\Models\Generadores;
use App\Helpers\JwtAuth;
use App\Services\FirebaseService;

class DetallesGeneradoresRepositorio
{
    protected $service;
    protected $dataBase;
    protected $collection = '/detalles_generadores';
    public function __construct()
    {
        $this->service = new FirebaseService;
        $this->dataBase = $this->service->db;
    }

    public function createDetalle($serial, $energia)
    {
        $generador = $this->findGenerador($serial);
        $fecha = date('Y-m-d');
        $uniqId = uniqid();
        $detalle_generador['_id'] = $uniqId;
        $detalle_generador['generador_id'] = $generador->id;
        $detalle_generador['fecha'] = $fecha;
        $detalle_generador['energia_producida'] = $energia;

        $this->dataBase->getReference($this->collection.'/'.$uniqId)->set($detalle_generador);

        $data = $this->statusSucces();
        return response()->json(compact('data', 'detalle_generador'));
    }

    public function listDetallesGeneradores($hash)
    {
        if ($this->headerToken($hash)) {
            $detalles_generadores = $this->getDetalles();
            for ($i=0; $i < count($detalles_generadores); $i++) { 
                $generador = $this->generador($detalles_generadores[$i]['generador_id']);
                $detalles_generadores[$i]['generador_id'] = $generador;
            }

            return $detalles_generadores;
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function generador($id)
    {
        $generador = Generadores::where('id','=', $id)->first();

        return $generador;
    }

    public function findGenerador($serial)
    {
        return Generadores::where('serial', '=', $serial)->first();
    }

    public function getDetalles()
    {
        $data = $this->dataBase->getReference($this->collection)->getValue();
        $detalles = [];
        if ($data) {
            foreach ($data as $clave => $valor) {
                array_push($detalles, $valor);
            }
        }
        return $detalles;
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
            'message' => 'Detalle de generador registrado correctamente'
        );

        return $data;
    }
}
