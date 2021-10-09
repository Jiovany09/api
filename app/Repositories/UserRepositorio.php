<?php

namespace App\Repositories;

use App\Models\User;
use App\Helpers\JwtAuth;

class UserRepositorio
{
    public function createCitizen($nombre, $paterno, $materno, $email, $password, $telefono)
    {
        $ciudadano['nombre'] = $nombre;
        $ciudadano['paterno'] = $paterno;
        $ciudadano['materno'] = $materno;
        $ciudadano['email'] = $email;
        $ciudadano['telefono'] = $telefono;
        $ciudadano['tipo'] = 'ciudadano';
        $ciudadano['password'] = hash('sha256', $password);

        User::create($ciudadano);

        $data = $this->statusSucces('Ciudadano');
        return response()->json(compact('data', 'ciudadano'));
    }

    public function login($email, $pwd)
    {
        $jwtAuth = new JwtAuth();

        $password = hash('sha256', $pwd);
        $signup = $jwtAuth->signup($email, $password);

        return $signup;
    }

    public function listCitizen($hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('tipo', '=', 'ciudadano')->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listCitizenEliminate($hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('tipo', '=', 'ciudadano')->onlyTrashed()->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function editCitizen($id, $nombre, $paterno, $materno, $telefono, $hash)
    {
        if ($this->headerToken($hash)) {
            $users = $this->find($id);
            $users->nombre = $nombre;
            $users->paterno = $paterno;
            $users->materno = $materno;
            $users->telefono = $telefono;
            $users->save();

            $data = $this->statusSuccesEdit();
            return response()->json(compact('data', 'users'));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function createAdministrator($nombre, $paterno, $materno, $email, $clave, $hash)
    {
        if ($this->headerToken($hash)) {
            $administradores['nombre'] = $nombre;
            $administradores['paterno'] = $paterno;
            $administradores['materno'] = $materno;
            $administradores['email'] = $email;
            $administradores['clave'] = $clave;
            $administradores['tipo'] = 'administrador';
            $administradores['password'] = hash('sha256', $clave . $paterno);

            return User::create($administradores);
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listAdministrator($hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('tipo', '=', 'administrador')->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listAdministratorEliminate($hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('tipo', '=', 'administrador')->onlyTrashed()->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function createEmployee($nombre, $paterno, $materno, $email, $clave, $hash)
    {
        if ($this->headerToken($hash)) {
            $empleados['nombre'] = $nombre;
            $empleados['paterno'] = $paterno;
            $empleados['materno'] = $materno;
            $empleados['email'] = $email;
            $empleados['clave'] = $clave;
            $empleados['tipo'] = 'empleado';
            $empleados['password'] = hash('sha256', $clave . $paterno);

            return User::create($empleados);
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listEmployee($hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('tipo', '=', 'empleado')->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function listEmployeeEliminate($hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('tipo', '=', 'empleado')->onlyTrashed()->get();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function edit($id, $nombre, $paterno, $materno, $email, $clave, $hash)
    {
        if ($this->headerToken($hash)) {
            $users = $this->find($id);
            $users->nombre = $nombre;
            $users->paterno = $paterno;
            $users->materno = $materno;
            $users->email = $email;
            $users->clave = $clave;
            $users->save();

            $data = $this->statusSuccesEdit();
            return response()->json(compact('data', 'users'));
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function delete($id, $hash)
    {
        if ($this->headerToken($hash)) {
            $users = $this->find($id);

            return $users->delete();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function restore($id, $hash)
    {
        if ($this->headerToken($hash)) {
            return User::onlyTrashed()->find($id)->restore();
        } else {
            return $this->errorAuthenticate();
        }
    }

    public function find($id)
    {
        return User::where('id', '=', $id)->first();
    }

    public function findProtected($id, $hash)
    {
        if ($this->headerToken($hash)) {
            return User::where('id', '=', $id)->first();
        } else {
            return $this->errorAuthenticate();
        }
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

    public function statusSucces($tipo)
    {
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => $tipo . ' registrado correctamente'
        );

        return $data;
    }

    public function statusSuccesEdit()
    {
        $data = array(
            'status' => 'success',
            'code' => 200,
            'message' => 'Se editó correctamente'
        );

        return $data;
    }
}
