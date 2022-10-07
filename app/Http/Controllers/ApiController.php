<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function auth(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if ($email && $password) {
            $c = DB::selectOne("SELECT * FROM users WHERE email = ? OR username = ?", [$email, $email]);
            if ($c) {
                if (Hash::check($password, $c->password)) {
                    return response()->json(["message" => $c, "success" => true], 200);
                } else {
                    return response()->json(["message" => 'Usuario y/o contraseña incorrectos', "success" => false], 205);
                }
            } else {
                return response()->json(["message" => 'Usuario y/o contraseña incorrectos', "success" => false], 205);
            }
        } else {
            return response()->json(["message" => 'error', "success" => false], 205);
        }
    }
    public function register_user(Request $request)
    {
        $email = null;
        $password =  null;
        $name =  null;
        $lastname = null;
        $user = null;
        //clean
        $email = strip_tags($request->input('email'));
        $password = strip_tags($request->input('password'));
        $name = strip_tags($request->input('name'));
        $lastname = strip_tags($request->input('lastname'));
        $user = strip_tags($request->input('user'));
        $pwd = Hash::make($password);
        $ch = DB::selectOne("SELECT COUNT(*) as c FROM users WHERE email = ?", [$email]);
        if ($ch->c == 0) {
            $ch = DB::selectOne("SELECT COUNT(*) as c FROM users WHERE username = ?", [$user]);
            if ($ch->c == 0) {
                try {
                    $stm = DB::insert(
                        "INSERT INTO users (id, name, lastname, email, username, password) VALUES (null, ?, ?, ?, ?, ?)",
                        [$name, $lastname, $email, $user, $pwd]
                    );
                    if ($stm) {
                        return response()->json(["message" => 'Usuario registrado correctamente', "success" => true], 200);
                    } else {
                        return response()->json(["message" => 'Error ya registrado', "success" => false], 205);
                    }
                } catch (Exception $e) {
                    return response()->json(["message" => $e->getMessage(), "success" => false], 205);
                }
            } else {
                return response()->json(["message" => 'Usuario ya registrado', "success" => false], 205);
            }
        } else {
            return response()->json(["message" => 'Email ya registrado', "success" => false], 205);
        }
    }
    public function regist_Asamblea_Escudo(Request $request)
    {
        $elemento = $request->elemento;
        $porque_identifica = $request->porque_identifica;
        if ($elemento && $porque_identifica) {
            $c = DB::insert("INSERT INTO as_escudo (id, elemento, identifica_comunidad) VALUES (null, ?, ?)", [$elemento, $porque_identifica]);
            if ($c) {
                return response()->json(["message" => 'Datos registrados correctamente, gracias!', "success" => true], 200);
            } else {
                return response()->json(["message" => 'Error ya registrado', "success" => false], 205);
            }
        } else {
            return response()->json(["message" => 'Error', "success" => false], 205);
        }
    }
    public function regisBuenaVida(Request $request)
    {
        $n_valor = $request->n_valor;
        $n_desc = $request->n_desc;
        $n_mejorar = $request->n_mejorar;
        $s_valor = $request->s_valor;
        $s_desc = $request->s_desc;
        $s_mejorar = $request->s_mejorar;
        $p_valor = $request->p_valor;
        $p_desc = $request->p_desc;
        $p_mejorar = $request->p_mejorar;
        $e_valor = $request->e_valor;
        $e_desc = $request->e_desc;
        $e_mejorar = $request->e_mejorar;
        $c_valor = $request->c_valor;
        $c_desc = $request->c_desc;
        $c_mejorar = $request->c_mejorar;
    }
}
