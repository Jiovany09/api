<?php

namespace App\Http\Controllers;

use App\Repositories\InfoTiempoRealRepositorio;
use Illuminate\Http\Request;

class InfoTiempoRealController extends Controller
{
    protected $info_repositorio;
    public function __construct(InfoTiempoRealRepositorio $_info)
    {
        $this->info_repositorio = $_info;
    }

    public function listInfoTiempoRealGenerador(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return $this->info_repositorio->listInfoTiempoRealGenerador($id,$hash);
    }

    public function listInfoTiempoRealContenedor(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return $this->info_repositorio->listInfoTiempoRealContenedor($id,$hash);
    }

    public function createInfoGenerador(Request $request)
    {
        $serial = $request->get('serial');
        $energia = $request->get('energia');

        return $this->info_repositorio->createInfoGenerador($serial,$energia);
    }

    public function createInfoContenedor(Request $request)
    {
        $serial = $request->get('serial');
        $energia = $request->get('energia');

        return $this->info_repositorio->createInfoContenedor($serial,$energia);
    }

    public function aumentarUsuarioGenerador(Request $request, $serial)
    {
        $hash = $request->header('Authorization', null);

        return $this->info_repositorio->aumentarUsuarioGenerador($serial,$hash);
    }

    public function decrementarUsuarioGenerador(Request $request, $serial)
    {
        $hash = $request->header('Authorization', null);

        return $this->info_repositorio->decrementarUsuarioGenerador($serial,$hash);
    }

    public function aumentarUsuarioContenedor(Request $request, $serial)
    {
        $hash = $request->header('Authorization', null);

        return $this->info_repositorio->aumentarUsuarioContenedor($serial,$hash);
    }

    public function decrementarUsuarioContenedor(Request $request, $serial)
    {
        $hash = $request->header('Authorization', null);

        return $this->info_repositorio->decrementarUsuarioContenedor($serial,$hash);
    }
}
