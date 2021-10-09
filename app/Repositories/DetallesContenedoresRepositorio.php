<?php

namespace App\Repositories;

use App\Helpers\JwtAuth;
use App\Models\Contenedores;
use App\Services\FirebaseService;

class DetallesContenedoresRepositorio
{
    protected $service;
    protected $dataBase;
    protected $collection = '/detalles_contenedores';
    public function __construct()
    {
        $this->service = new FirebaseService;
        $this->dataBase = $this->service->db;
    }

    public function createDetalleContenedor($serial, $energia)
    {
        $contenedor = $this->findContenedor($serial);
        $fecha = date('Y-m-d');
        $uniqId = uniqid();
        $detalle_contenedor['_id'] = $uniqId;
        $detalle_contenedor['contenedor_id'] = $contenedor->id;
        $detalle_contenedor['fecha'] = $fecha;
        $detalle_contenedor['energia_consumida'] = $energia;

        $this->dataBase->getReference($this->collection . '/' . $uniqId)->set($detalle_contenedor);

        $data = $this->statusSucces();
        return response()->json(compact('data', 'detalle_contenedor'));
    }

    public function listDetallesContenedores($hash)
    {
        if ($this->headerToken($hash)) {
            $detalles_contenedores = $this->getDetalles();
            for ($i = 0; $i < count($detalles_contenedores); $i++) {
                $contenedor = $this->contenedor($detalles_contenedores[$i]['contenedor_id']);
                $detalles_contenedores[$i]['contenedor_id'] = $contenedor;
            }

            return $detalles_contenedores;
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function contenedor($id)
    {
        $contenedor = Contenedores::where('id', '=', $id)->first();

        return $contenedor;
    }

    public function findContenedor($serial)
    {
        return Contenedores::where('serial', '=', $serial)->first();
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
