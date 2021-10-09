<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DetallesContenedoresRepositorio;
use App\Validations\DetallesContenedoresValidations;

class DetalleContenedorController extends Controller
{
    protected $detalle_contenedor_repositorio;
    protected $detalle_contenedor_validations;
    public function __construct(DetallesContenedoresRepositorio $_detalle_contenedor_repositorio, DetallesContenedoresValidations $_detalle_contenedor_validations)
    {
        $this->detalle_contenedor_repositorio = $_detalle_contenedor_repositorio;
        $this->detalle_contenedor_validations = $_detalle_contenedor_validations;
    }

    public function createDetalleContenedor(Request $request)
    {
        $validacion = $this->detalle_contenedor_validations->createDetalleContenedor($request);
        if ($validacion != null) {
            return $validacion;
        }

        $serial = $request->input('serial');
        $energia = $request->input('energia');

        return $this->detalle_contenedor_repositorio->createDetalleContenedor($serial,$energia);
    }

    public function listDetallesContenedores(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->detalle_contenedor_repositorio->listDetallesContenedores($hash));
    }
}
