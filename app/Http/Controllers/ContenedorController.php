<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ContenedoresRepositorio;
use App\Validations\ContenedoresValidations;

class ContenedorController extends Controller
{
    protected $contenedores_repositorio;
    protected $contenedores_validaciones;
    public function __construct(ContenedoresRepositorio $_contenedoresRepositorie, ContenedoresValidations $_contenedoresValidations)
    {
        $this->contenedores_repositorio = $_contenedoresRepositorie;
        $this->contenedores_validaciones = $_contenedoresValidations;
    }

    public function createContenedores(Request $request)
    {
        $validacion = $this->contenedores_validaciones->createContenedores($request);
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);

        $empleado_id = $request->input('empleado_id');
        $generador_id = $request->input('generador_id');
        $serial = $request->input('serial');

        return $this->contenedores_repositorio->createContenedores($empleado_id,$generador_id,$serial,$hash);
    }

    public function listContenedores(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->contenedores_repositorio->listContenedores($hash));
    }

    public function listContenedoresEliminate(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->contenedores_repositorio->listContenedoresEliminate($hash));
    }

    public function editContenedores(Request $request,$id)
    {
        $validacion = $this->contenedores_validaciones->editContenedores($request,$id);
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);

        $empleado_id = $request->get('empleado_id');
        $generador_id = $request->get('generador_id');
        $serial = $request->get('serial');

        return $this->contenedores_repositorio->editContenedores($id,$empleado_id,$generador_id,$serial,$hash);
    }

    public function deleteContenedores(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->contenedores_repositorio->deleteContenedores($id,$hash));
    }

    public function restoreContenedores(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->contenedores_repositorio->restoreContenedores($id,$hash));
    }

    public function activarDesactivarContenedores(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->contenedores_repositorio->activarDesactivarContenedores($id,$hash));
    }

    public function findProtected(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->contenedores_repositorio->findProtected($id,$hash));
    }
}
