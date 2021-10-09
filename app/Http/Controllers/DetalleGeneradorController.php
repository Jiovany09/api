<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DetallesGeneradoresRepositorio;
use App\Validations\DetallesGeneradoresValidations;

class DetalleGeneradorController extends Controller
{
    protected $detalles_generadores_repositorio;
    protected $detalles_generadores_validations;
    public function __construct(DetallesGeneradoresRepositorio $_detalles_generadores_repositorio, DetallesGeneradoresValidations $_detalles_generadores_validations)
    {
        $this->detalles_generadores_repositorio = $_detalles_generadores_repositorio;
        $this->detalles_generadores_validations = $_detalles_generadores_validations;
    }

    public function createDetalleGenerador(Request $request)
    {
        $validacion = $this->detalles_generadores_validations->createDetalle($request);
        if ($validacion != null) {
            return $validacion;
        }

        $serial = $request->input('serial');
        $energia = $request->input('energia');

        return $this->detalles_generadores_repositorio->createDetalle($serial,$energia);
    }

    public function listDetallesGeneradores(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->detalles_generadores_repositorio->listDetallesGeneradores($hash));
    }
}
