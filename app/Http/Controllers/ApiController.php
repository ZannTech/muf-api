<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //
    public function auth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if ($email && $password) {
            $c = DB::selectOne("SELECT * FROM users WHERE email = ? OR username = ?", [$email, $email]);
            if ($c) {
                $pwd = $c->password;
                if (Hash::check($email, $pwd)) {
                    return response()->json(["message" => "Correcto"], 200);
                } else {
                    return response()->json(["message" => "Usuario correcto.", "status" => 200], 205);
                }
            } else {
                return response()->json(["message" => "Usuario y/o contraseña incorrectos.", "status" => 205], 205);
            }
        } else {
            return response()->json(["message" => "Consulta erronea", "status" => 205], 205);
        }
    }
}
