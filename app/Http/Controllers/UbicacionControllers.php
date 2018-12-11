<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Models\Usuarios,
    App\Models\Ubicaciones,
    App\Models\Personas,
    Illuminate\Support\Facades\Validator;


class UbicacionControllers extends Controller
{
    private $usuario = null,$ubicacion = null, $persona = null, $users = null;

    public function __construct()
    {
        $this->usuario = new Usuarios();
        $this->persona = new Personas();
        $this->ubicacion = new Ubicaciones();
        $this->users = $this->usuario->api_Auth();
        if(!$this->users["estado"]){
            return response()->json(["estado"=>false,"error"=>"Sesíon invalidad"]);
        }
    }

    public function guardar(){
        return response()->json($this->ubicacion->guardar());
    }

    public function ver(){
       return response()->json($this->ubicacion->obtenerUbicacion());
    }

    public function eliminar(Request $request){
    }

    public function actualizar(Request $request){
    }

    public function ubicacionUsuarios(){
        return $this->ubicacion->ubicacionUsuarios();
    }
}
