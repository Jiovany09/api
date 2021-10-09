<?php

namespace App\Repositories;

use App\Models\Contenedores;
use App\Models\Generadores;
use App\Models\Lamparas;

class ArduinosRepositorio
{
    public function estadoGenerador($serial)
    {
        $generador = $this->busquedaGenerador($serial);
        if ($generador->estado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function estadoContenedor($serial)
    {
        $contenedor = $this->busquedaContenedor($serial);
        if ($contenedor->estado) {
            return 1;
        } else {
            return 0;
        }
    }

    public function estadoLampara($id)
    {
        $lampara = $this->busquedaLampara($id);
        if ($lampara->estado) {
            return 1;
        } else { 
            return 0;
        }
    }

    public function estadoConsultaInformacionWeb($serial)
    {
        $generador = $this->busquedaGenerador($serial);
        if ($generador->contador == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function estadoConsultaInformacionApp($serial)
    {
        $contenedor = $this->busquedaContenedor($serial);
        if ($contenedor->contador == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function busquedaGenerador($serial)
    {
        return Generadores::where('serial', '=', $serial)->first();
    }

    public function busquedaContenedor($serial)
    {
        return Contenedores::where('serial', '=', $serial)->first();
    }

    public function busquedaLampara($id)
    {
        return Lamparas::where('id','=',$id)->first();
    }
}
