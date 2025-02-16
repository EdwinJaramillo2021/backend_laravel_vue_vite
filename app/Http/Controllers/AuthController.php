<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request)
    {
        //validar
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //autenticar
        if (!Auth::attempt($credenciales)) {
            return response()->json(['message' => 'Credenciales incorrectas']);
        }
        //obtener usuario autentificado
        $usuario = $request->user();
        //generamos token
        $token = $usuario->createToken('Token auth')->plainTextToken;
        //respuesta
        return response()->json(['access_token' => $token, 'usuario' => $usuario], 201);
    }

    public function funRegister(Request $request)
    {
        //validar
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|same:c_password'
        ]);
        //guardar
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        //generar respuesta
        return response()->json(['message' => 'Usuario registrado'], 201);
    }
    public function funProfile(Request $request)
    {
        //obtener el usuario autentificado
        $usuario = $request->user();
        //devolver la información del usuario
        return response()->json($usuario);
    }

    public function funLogout(Request $request)
    {
        //revocar el token
        $request->user()->tokens()->delete();
        //devolver respuesta
        return response()->json(['message' => 'Sesion cerrada']);
    }
}
