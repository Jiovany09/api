<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GraficasConsumosRepositorio;

class GraficaConsumoController extends Controller
{
    protected $graficas_repositorio;
    public function __construct(GraficasConsumosRepositorio $_graficas)
    {
        $this->graficas_repositorio = $_graficas;
    }

    public function listInfo(Request $request, $tipo)
    {
        $hash = $request->header('Authorization', null);

        return $this->graficas_repositorio->listInfo($tipo,$hash);
    }
}
