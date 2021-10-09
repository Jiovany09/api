<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GeneradoresRepositorio;
use App\Validations\GeneradoresValidations;
use App\Models\Generadores;

class GeneradorController extends Controller
{
    protected $generadores_repositorio;
    protected $generadores_validations;
    public function __construct(GeneradoresRepositorio $_generadoresRepositorio, GeneradoresValidations $_generadoresValidations)
    {
        $this->generadores_repositorio = $_generadoresRepositorio;
        $this->generadores_validations = $_generadoresValidations;
    }

    public function createGeneradores(Request $request)
    {
        $validacion = $this->generadores_validations->createGeneradores($request);
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);

        $serial = $request->input('serial');

        return $this->generadores_repositorio->createGeneradores($serial,$hash);
    }

    public function listGeneradores(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->generadores_repositorio->listGeneradores($hash));
    }

    public function listGeneradoresEliminate(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->generadores_repositorio->listGeneradoresEliminate($hash));
    }

    public function editGeneradores(Request $request,$id)
    {
        $validacion = $this->generadores_validations->editGeneradores($request,$id);
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);

        $serial = $request->get('serial');

        return $this->generadores_repositorio->editGeneradores($id,$serial,$hash);
    }

    public function eliminateGeneradores(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->generadores_repositorio->eliminateGeneradores($id,$hash));
    }

    public function activarDesactivar(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->generadores_repositorio->activarDesactivar($id,$hash));
    }

    public function restoreGeneradores(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->generadores_repositorio->restoreGeneradores($id,$hash));
    }

    public function findProtected(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->generadores_repositorio->findProtected($id,$hash));
    }

    public function arduino($serial)
    {
        $generador = Generadores::where('serial','=',$serial)->get();
        return $generador[0]->estado;
    }
}
