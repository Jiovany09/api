<?php

namespace App\Http\Controllers;

use App\Repositories\ArduinosRepositorio;

class ArduinoController extends Controller
{
    protected $arduino_repositorio;
    public function __construct(ArduinosRepositorio $_arduinoRepositorio)
    {
        $this->arduino_repositorio = $_arduinoRepositorio;
    }

    public function estadoGenerador($serial)
    {
        return $this->arduino_repositorio->estadoGenerador($serial);
    }

    public function estadoContenedor($serial)
    {
        return $this->arduino_repositorio->estadoContenedor($serial);
    }

    public function estadoLampara($id)
    {
        return $this->arduino_repositorio->estadoLampara($id);
    }

    public function estadoConsultaInformacionWeb($serial)
    {
        return $this->arduino_repositorio->estadoConsultaInformacionWeb($serial);
    }

    public function estadoConsultaInformacionApp($serial)
    {
        return $this->arduino_repositorio->estadoConsultaInformacionApp($serial);
    }
}
