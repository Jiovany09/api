<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepositorio;
use App\Validations\UserValidations;

class UserController extends Controller
{
    //
    protected $user_repositorio;
    protected $user_validations;
    public function __construct(UserRepositorio $_userRespositorio, UserValidations $_userValidations)
    {
        $this->user_repositorio = $_userRespositorio;
        $this->user_validations = $_userValidations;
    }

    public function register(Request $request)
    {
        $validacion = $this->user_validations->userCreateCitizen($request);
        if ($validacion != null) {
            return $validacion;
        }

        $nombre = $request->input('nombre');
        $paterno = $request->input('paterno');
        $materno = $request->input('materno');
        $email = $request->input('email');
        $password = $request->input('password');
        $telefono = $request->input('telefono');

        return $this->user_repositorio->createCitizen($nombre,$paterno,$materno,$email,$password,$telefono);
    }

    public function login(Request $request)
    {
        $validacion = $this->user_validations->login($request);
        if ($validacion != null) {
            return $validacion;
        }

        $password = $request->get('password');
        $email = $request->get('email');

        return $this->user_repositorio->login($email, $password);
    }

    public function listCitizen(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->listCitizen($hash));
    }

    public function listCitizenEliminate(Request $request)
    {
        $hash = $request->header('Authorization', null);
        
        return response()->json($this->user_repositorio->listCitizenEliminate($hash));
    }

    public function editCitizen(Request $request,$id)
    {
        $validacion = $this->user_validations->editCitizen($request,$id);
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);
        
        $nombre = $request->get('nombre');
        $paterno = $request->get('paterno');
        $materno = $request->get('materno');
        $telefono = $request->get('telefono');

        return $this->user_repositorio->editCitizen($id,$nombre,$paterno,$materno,$telefono,$hash);
    }

    public function createAdministrator(Request $request)
    {
        $validacion = $this->user_validations->userCreateAdministratorEmployee($request,'Administrador');
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);

        $nombre = $request->input('nombre');
        $paterno = $request->input('paterno');
        $materno = $request->input('materno');
        $email = $request->input('email');
        $clave = $request->input('clave');

        return response()->json($this->user_repositorio->createAdministrator($nombre,$paterno,$materno,$email,$clave,$hash));
    }

    public function listAdministrator(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->listAdministrator($hash));
    }

    public function listAdministratorEliminate(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->listAdministratorEliminate($hash));
    }

    public function createEmployee(Request $request)
    {
        $validacion = $this->user_validations->userCreateAdministratorEmployee($request,'Empleado');
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);

        $nombre = $request->input('nombre');
        $paterno = $request->input('paterno');
        $materno = $request->input('materno');
        $email = $request->input('email');
        $clave = $request->input('clave');

        return response()->json($this->user_repositorio->createEmployee($nombre,$paterno,$materno,$email,$clave,$hash));
    }

    public function listEmployee(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->listEmployee($hash));
    }

    public function listEmployeeEliminate(Request $request)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->listEmployeeEliminate($hash));
    }

    public function edit(Request $request, $id)
    {
        $validacion = $this->user_validations->userEditAdministratorEmployee($request,$id);
        if ($validacion != null) {
            return $validacion;
        }

        $hash = $request->header('Authorization', null);
        
        $nombre = $request->get('nombre');
        $paterno = $request->get('paterno');
        $materno = $request->get('materno');
        $email = $request->get('email');
        $clave = $request->get('clave');

        return $this->user_repositorio->edit($id,$nombre,$paterno,$materno,$email,$clave,$hash);
    }

    public function delete(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->delete($id,$hash));
    }

    public function restore(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);

        return response()->json($this->user_repositorio->restore($id,$hash));
    }

    public function findUser(Request $request,$id)
    {
        $hash = $request->header('Authorization', null);
        
        return response()->json($this->user_repositorio->findProtected($id,$hash));
    }
}
