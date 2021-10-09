<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LamparasRepositorio;
use App\Validations\LamparasValidations;

class LamparaController extends Controller
{
    protected $lamparas_repositorio;
    protected $lamparas_validations;
    public function __construct(LamparasRepositorio $_lamparasRepositorio, LamparasValidations $_lamparasValidations)
    {
        $this->lamparas_repositorio = $_lamparasRepositorio;
        $this->lamparas_validations = $_lamparasValidations;
    }

    public function createLampara(Request $request)
    {
        $validations = $this->lamparas_validations->createLampara($request);
        if ($validations != null) {
            return $validations;
        }

        $hash = $request->header('Authorization', null);

        $contenedor_id = $request->input('contenedor_id');

        return $this->lamparas_repositorio->createLampara($contenedor_id,$hash);
    }

    public function listLamparas(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->listLamparas($hash));
    }

    public function listLamparasEliminate(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->listLamparasEliminate($hash));
    }

    public function editLamparas(Request $request,$id)
    {
        $validations = $this->lamparas_validations->editLamparas($request);
        if ($validations != null) {
            return $validations;
        }

        $hash = $request->header('Authorization', null);

        $contenedor_id = $request->get('contenedor_id');

        return $this->lamparas_repositorio->editLamparas($id,$contenedor_id,$hash);
    }

    public function deleteLamparas(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->deleteLamparas($id,$hash));
    }

    public function activarDesactivarLamparas(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->activarDesactivarLamparas($id,$hash));
    }

    public function restoreLamparas(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->restoreLamparas($id,$hash));
    }

    public function findProtected(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->findProtected($id,$hash));
    }

    public function listByContainer(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->lamparas_repositorio->listByContainer($id,$hash));
    }
}
