<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    //Función index
    public function index(){
        $datos = DB::select('select * from usuarios');
        return view("welcome")->with("datos", $datos);
    }

    public function create(Request $request){
        try{
            $sql=DB::insert("insert into usuarios(nombre,apellido,correo,contraseña)values(?,?,?,?)",[
                $request->txtnombre,
                $request->txtapellido,
                $request->txtcorreo,
                $request->txtcontraseña
            ]);
        }catch(\Throwable $th){
            $sql=0;
        }
        if($sql == true){
            return back()->with("correcto","Usuario registrado correctamente");
        }else{
            return back()->with("incorrecto","Error al registrar");
        }
    }

    public function update(Request $request){
        try{
            $sql=DB::update(" update usuarios set nombre=?, apellido=?, correo=?, contraseña=? where id_usuario=? ",[
                $request->txtnombre,
                $request->txtapellido,
                $request->txtcorreo,
                $request->txtcontraseña,
                $request->txtcodigo,
            ]);
            if($sql==0){
                $sql=1;
            }
        }catch (\Throwable $th){
            $sql=0;
        }
        if($sql == true){
            return back()->with("correcto","Usuario modificado correctamente");
        }else{
            return back()->with("incorrecto","Error al modificar");
        }
    }

    public function delete($id){
        try{
            $sql=DB::delete('delete from usuarios where id_usuario=?',[
                $id
            ]);
        }catch(\Throwable $th){
            $sql=0;
        }
        if($sql == true){
            return back()->with("correcto","Usuario eliminado correctamente");
        }else{
            return back()->with("incorrecto","Error al eliminar");
        }
    }
}
