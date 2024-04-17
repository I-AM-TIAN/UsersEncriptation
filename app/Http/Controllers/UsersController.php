<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersController extends Controller
{
    //Función index
    public function index()
    {   
        $datos = DB::select("SELECT id_usuario, Nombre, Apellido, Correo, Contraseña ,AES_DECRYPT(Contraseña, 'AES') AS Password FROM `usuarios`");

        return view("welcome")->with("datos", $datos);
    }

    public function create(Request $request)
    {
        try {
            $contrasenaCifrada = $request->txtcontraseña;
            $nombre = $request->txtnombre;
            $apellido = $request->txtapellido;
            $correo = $request->txtcorreo;

            $sql = DB::insert("insert into usuarios(nombre,apellido,correo,contraseña)values('$nombre','$apellido','$correo',AES_ENCRYPT('$contrasenaCifrada','AES'))");
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Usuario registrado correctamente");
        } else {
            return back()->with("incorrecto", "Error al registrar");
        }
    }

    public function update(Request $request)
    {
        try {
            $contrasenaCifrada = $request->txtcontraseña;
            $sql = DB::update(" update usuarios set nombre=?, apellido=?, correo=?, AEScontraseña=? where id_usuario=? ", [
                $request->txtnombre,
                $request->txtapellido,
                $request->txtcorreo,
                $contrasenaCifrada,
                $request->txtcodigo,
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Usuario modificado correctamente");
        } else {
            return back()->with("incorrecto", "Error al modificar");
        }
    }

    public function delete($id)
    {
        try {
            $sql = DB::delete('delete from usuarios where id_usuario=?', [
                $id
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == true) {
            return back()->with("correcto", "Usuario eliminado correctamente");
        } else {
            return back()->with("incorrecto", "Error al eliminar");
        }
    }

    public function verification($password)
    {
        try {
            $decrypted = Crypt::decrypt($password);
        } catch (DecryptException $e) {
            
        }
        return view("prints")->with("clave", $decrypted);
    }
}
