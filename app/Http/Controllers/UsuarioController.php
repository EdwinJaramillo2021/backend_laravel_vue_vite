<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
    {   //el modelo es User esta asociado a la tabla usuers
        //select * from users;
        $usuarios = User::get();
        //$tabla_pivot = DB::table("role_user")->join('users', 'users.id', "role_user.user_id")->where("user_id", "=", 2)->count();
        return response()->json($usuarios, 200);
    }

    public function store(UsuarioRequest $request)
    {/*
        $nombre = $request->name;
        $email = $request->email;
        DB::insert("insert into users(name,email) values(?,?)", [$nombre, $email]);*/
        /*
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required'
        ]);*/
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();
        return response()->json(['message' => 'Usuario registrado correctamente'], 201);
    }

    public function show(string $id)
    {
        $usuario = User::find($id);
        return response()->json($usuario, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,$id',
            'password' => 'required'
        ]);
        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();
        return response()->json(['message' => 'Usuario actualizado'], 200);
    }

    public function destroy(string $id)
    {
        $usuario = User::find($id);
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}
