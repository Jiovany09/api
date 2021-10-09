<?php

namespace App\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserValidations
{
    public function userCreateCitizen(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:20',
            'paterno' => 'required|string|max:15',
            'materno' => 'max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:30',
            'telefono' => 'required|string|max:10|unique:users'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusError('Ciudadano');
            return response()->json(compact('data','error'));
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|max:30'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusLogin();
            return response()->json(compact('data','error'));
        }
    }

    public function userCreateAdministratorEmployee(Request $request,$tipo)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:20',
            'paterno' => 'required|string|max:15',
            'materno' => 'max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'clave' => 'required|string|max:20|unique:users'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toJson();
            $data = $this->statusError($tipo);
            return response()->json(compact('data','error'));
        }
    }

    public function userEditAdministratorEmployee(Request $request,$id)
    {
        $users = User::where('id','=',$id)->first();
        if ($users->email == $request->get('email') && $users->clave == $request->get('clave')) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:20',
                'paterno' => 'required|string|max:15',
                'materno' => 'max:15',
                'email' => 'required|string|email|max:255',
                'clave' => 'required|string|max:20'
            ]);

            if ($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        } else if ($users->email == $request->get('email')) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:20',
                'paterno' => 'string|max:15',
                'materno' => 'string|max:15',
                'email' => 'required|string|email|max:255',
                'clave' => 'required|string|max:20|unique:users'
            ]);
    
            if ($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        } else if ($users->clave == $request->get('clave')) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:20',
                'paterno' => 'required|string|max:15',
                'materno' => 'max:15',
                'email' => 'required|string|email|max:255|unique:users',
                'clave' => 'required|string|max:20'
            ]);

            if ($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        } else {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:20',
                'paterno' => 'required|string|max:15',
                'materno' => 'max:15',
                'email' => 'required|string|email|max:255|unique:users',
                'clave' => 'required|string|max:20|unique:users'
            ]);
    
            if ($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        }
    }

    public function editCitizen(Request $request,$id)
    {
        $users = User::where('id','=',$id)->first();
        if ($users->telefono == $request->get('telefono')) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:20',
                'paterno' => 'required|string|max:15',
                'materno' => 'max:15',
                'telefono' => 'required|string|max:10'
            ]);
    
            if ($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        } else {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:20',
                'paterno' => 'required|string|max:15',
                'materno' => 'max:15',
                'telefono' => 'required|string|max:10|unique:users'
            ]);
    
            if ($validator->fails()){
                $error = $validator->errors()->toJson();
                $data = $this->statusEditError();
                return response()->json(compact('data','error'));
            }
        }   
    }

    public function statusLogin()
    {
        $data = array(
            'status' => 'error',
            'message' => 'Error al iniciar sesión'
        );

        return $data;
    }

    public function statusError($tipo)
    {
        $data = array(
            'status' => 'error',
            'code' => 400,
            'message' => $tipo.' no registrado'
        );

        return $data;
    }

    public function statusEditError()
    {
        $data = array(
            'status' => 'error',
            'message' => 'No se editó el registro'
        );

        return $data;
    }
}