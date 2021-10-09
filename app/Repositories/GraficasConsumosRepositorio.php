<?php

namespace App\Repositories;

use App\Models\Contenedores;
use App\Helpers\JwtAuth;
use App\Services\FirebaseService;

class GraficasConsumosRepositorio
{
    protected $service;
    protected $dataBase;
    protected $collection = '/detalles_contenedores';
    public function __construct()
    {
        $this->service = new FirebaseService;
        $this->dataBase = $this->service->db;
    }

    public function listInfo($tipo,$hash)
    {
        if ($this->headerToken($hash)) {
            switch ($tipo) {
                case 'dia':
                    return $this->infoDias();
                    break;
                case 'semana':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                case 'mes':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                case 'bimestre':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                case 'trimestre':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                case 'cuatrimestre':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                case 'semestre':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                case 'anio':
                    return 'Esta en proceso el envio por '.$tipo;
                    break;
                default:
                    return 'Eso que pedo men, agarra la onda';
                    break;
            }
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function infoDias()
    {
        $limiteMenor = $this->comprobacionFecha();
        $arregloFechas = $this->fechas();
        $detallesContenedores = $this->getDetalles($limiteMenor);
        $contenedores = Contenedores::all();
        $infoGeneral = array();
        $data = array();
        for ($i=0; $i < count($contenedores); $i++) {
            $energiaConsumida = array();
            $data['id'] = $contenedores[$i]->id;
            $data['contenedor'] = $contenedores[$i]->contenedor;
            for ($j=0; $j < count($detallesContenedores); $j++) { 
                if ($contenedores[$i]->id == $detallesContenedores[$j]['contenedor_id']) {
                    $energia = array (
                        'fecha' => $detallesContenedores[$j]['fecha'],
                        'energia' => $detallesContenedores[$j]['energia_consumida']
                    );
                    array_push($energiaConsumida,$energia);
                }
            }
            $data['data'] = $energiaConsumida;
            array_push($infoGeneral,$data);
        }
        return response()->json(compact('infoGeneral','arregloFechas'));
    }

    public function getDetalles($limiteMenor)
    {
        $data = $this->dataBase->getReference($this->collection)->getValue();
        $fecha = date('Y-m-d');
        $detalles = [];
        if ($data) {
            foreach ($data as $key => $value) {
                // if ($value['fecha'] < $fecha && $value['fecha'] >= $limiteMenor) {
                array_push($detalles,$value);
                // }
            }
        }
        return $detalles;
    }

    public function comprobacionFecha()
    {
        $fecha = new \DateTime();
        $dia = $fecha->format('d');
        $limiteMenor = '';
        if ($dia <= 7) {
            $mes = $fecha->format('m');
            if ($mes == 1) {
                $anio = $fecha->format('Y') - 1;
                switch ($dia) {
                    case 7:
                        $limiteMenor = $anio.'-12-31';
                        break;
                    case 6:
                        $limiteMenor = $anio.'-12-30';
                        break;
                    case 5:
                        $limiteMenor = $anio.'-12-29';
                        break;
                    case 4:
                        $limiteMenor = $anio.'-12-28';
                        break;
                    case 3:
                        $limiteMenor = $anio.'-12-27';
                        break;
                    case 2:
                        $limiteMenor = $anio.'-12-26';
                        break;
                    case 1:
                        $limiteMenor = $anio.'-12-25';
                        break;
                    default:
                        return 'Error';
                        break;
                }
                return $limiteMenor;
            }else {
                $mesAnterior = $mes - 1;
                if ($mesAnterior == 1 || $mesAnterior == 3 || $mesAnterior == 5 || $mesAnterior == 7 || $mesAnterior == 8 || $mesAnterior == 10 || $mesAnterior == 12) {
                    switch ($dia) {
                        case 7:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-31';
                            break;
                        case 6:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-30';
                            break;
                        case 5:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-29';
                            break;
                        case 4:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-28';
                            break;
                        case 3:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-27';
                            break;
                        case 2:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-26';
                            break;
                        case 1:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-25';
                            break;
                        default:
                            return 'Error';
                            break;
                    }
                } else if ($mesAnterior == 2) {
                    switch ($dia) {
                        case 7:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-28';
                            break;
                        case 6:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-27';
                            break;
                        case 5:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-26';
                            break;
                        case 4:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-25';
                            break;
                        case 3:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-24';
                            break;
                        case 2:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-23';
                            break;
                        case 1:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-22';
                            break;
                        default:
                            return 'Error';
                            break;
                    }
                } else {
                    switch ($dia) {
                        case 7:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-30';
                            break;
                        case 6:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-29';
                            break;
                        case 5:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-28';
                            break;
                        case 4:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-27';
                            break;
                        case 3:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-26';
                            break;
                        case 2:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-25';
                            break;
                        case 1:
                            $limiteMenor = $fecha->format('Y-').$mesAnterior.'-24';
                            break;
                        default:
                            return 'Error';
                            break;
                    }
                }
            }
        } else {
            $mesAnio = $fecha->format('Y-m-');
            $limiteMenor = $dia - 7;
            if ($limiteMenor < 10 && $limiteMenor > 0) {
                $limiteMenor = $mesAnio.'0'.$limiteMenor;
            } else {
                $limiteMenor = $mesAnio.$limiteMenor;
            }
        }
        return $limiteMenor;
    }

    public function fechas()
    {
        $arrayMeses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $arrayMesesIngles = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $arregloFechas = array();
        $arreglo = array();
        $fechas = new \DateTime();
        $mes = $fechas->format('F');
        $dia = $fechas->format('d');
        $mesAnterior = '';
        if ($dia <= 7) {
            if ($mes == 'Ene') {
                $mesAnterior = 'Dic';
                $mes = 'Ene';
                $numeroMes = 12;
            } else {
                for ($i=0; $i < count($arrayMeses); $i++) {
                    if ($mes == $arrayMesesIngles[$i]) {
                        $mes = $arrayMeses[$i];
                        $mesAnterior = $arrayMeses[$i-1];
                        $numeroMes = $i;
                    }
                }
            }
            $const = 1;
            $diaMesAnterior = 8 - $dia;
            for ($k = $dia; $k != 1; $k--) {
                $dia = $dia - $const;
                $arreglo['fechaGrafica'] = $mes.' '.$dia;
                $arreglo['fecha'] = $fechas->format('Y-m').'-0'.$dia;
                array_push($arregloFechas,$arreglo);
            }
            if ($mesAnterior == $arrayMeses[0] || $mesAnterior == $arrayMeses[2] || $mesAnterior == $arrayMeses[4] || $mesAnterior == $arrayMeses[6] || $mesAnterior == $arrayMeses[7] || $mesAnterior == $arrayMeses[9] || $mesAnterior == $arrayMeses[11]) {
                $dias = 31;
            } else  if ($mesAnterior == $arrayMeses[1]) {
                $dias = 28;
            } else {
                $dias = 30;
            }
            if ($mesAnterior == 'Dic') {
                $anio = $fechas->format('Y') - 1;
                for ($l = 0; $l < $diaMesAnterior; $l++) { 
                    $arreglo['fechaGrafica'] = $mesAnterior.' '.$dias;
                    if ($numeroMes < 10) {
                        $arreglo['fecha'] = $anio.'-0'.$numeroMes.'-'.$dias;
                    } else {
                        $arreglo['fecha'] = $anio.'-'.$numeroMes.'-'.$dias;
                    }
                    array_push($arregloFechas,$arreglo);
                    $dias--;
                }
            } else {
                for ($l = 0; $l < $diaMesAnterior; $l++) { 
                    $arreglo['fechaGrafica'] = $mesAnterior.' '.$dias;
                    if ($numeroMes < 10) {
                        $arreglo['fecha'] = $fechas->format('Y-0').$numeroMes.'-'.$dias;
                    } else {
                        $arreglo['fecha'] = $fechas->format('Y-').$numeroMes.'-'.$dias;
                    }
                    array_push($arregloFechas,$arreglo);
                    $dias--;
                }
            }
        }else {
            for ($i=0; $i < count($arrayMeses); $i++) {
                if ($mes == $arrayMesesIngles[$i]) {
                    $mes = $arrayMeses[$i];
                }
            }
            $const = 1;
            for ($k=7; $k != 0; $k--) {
                $dia = $dia - $const;
                $arreglo['fechaGrafica'] = $mes.' '.$dia;
                if ($dia < 10) {
                    $arreglo['fecha'] = $fechas->format('Y-m').'-0'.$dia;
                } else {
                    $arreglo['fecha'] = $fechas->format('Y-m').'-'.$dia;
                }
                array_push($arregloFechas,$arreglo);
            }
        }
        return $arregloFechas;
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
}