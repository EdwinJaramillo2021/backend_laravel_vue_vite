<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users"
        ]);

        $token = Str::random(64);

        Mail::send('email.recuperar-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject("Recuperar contraseña");
        });

        return response()->json(["status" => "Enviamos un correo con todas las instrucciones"]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "token" => "required",
            "password" => "required|min:8|confirmed"
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Password::validate($request->token, $user)) {
            return response()->json(["error" => "Token inválido o usuario no encontrado"], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["status" => "Contraseña cambiada correctamente"]);
    }
}
