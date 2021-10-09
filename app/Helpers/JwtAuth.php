<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use App\Models\User;

class JwtAuth
{
    private $key;

    public function __construct()
    {
        $this->key = '4d6c870621ea7d29883fc68b48acc54a9f4ca2d8a4aa7f8d333d6907af0a710f';
    }

    public function signup($email, $password)
    {
        $data = User::where(
            array(
                'email' => $email,
                'password' => $password
            ))->first();
            
        $signup = false;
        if (is_object($data)) {
            $signup = true;
        }

        if ($signup) {
            $user = array(
                'sub' => $data->id,
                'email' => $data->email,
                'nombre' => $data->nombre,
                'paterno' => $data->paterno,
                'materno' => $data->materno,
                'tipo' => $data->tipo,
                'telefono' => $data->telefono,
                'clave' => $data->clave,
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            );

            $token = JWT::encode($user, $this->key, 'HS256');

            return response()->json(compact('user','token'));
        } else {
            return array('status' => 'error', 'message' => 'El login ha fallado');
        }
    }

    public function checkToken($jwt, $getIdentity = false)
    {
        $auth = false;
        try {
            $decoded = JWT::decode($jwt, $this->key, array('HS256'));
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }

        if (isset($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        } else {
            $auth = false;
        }

        if ($getIdentity) {
            return $decoded;
        }

        return $auth;
    }
}