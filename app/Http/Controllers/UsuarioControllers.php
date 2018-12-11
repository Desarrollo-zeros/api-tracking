<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request,
    App\Models\Usuarios,
    App\Models\Ubicaciones,
    App\Models\Personas,
    Illuminate\Support\Facades\Validator;

class UsuarioControllers extends Controller
{
    private $usuario = null,$ubicacion = null, $persona = null, $users = null;

    public function __construct()
    {
        $this->usuario = new Usuarios();
        $this->persona = new Personas();
    }

    /*Iniciar Sesíon POST*/
    public function iniciar(Request $request){
        $credencial = filter_var($request->username,FILTER_VALIDATE_EMAIL) ?
            $request->only('email', 'password') :
            $request->only('username', 'password');

        return response()->json($this->usuario->auth($credencial));
    }

    /*Cerrar Sesíon*/
    public function salir(){}

    /*Registrar Usuario POST*/
    public function registrar(Request $request){

        $validator = Validator::make($request->all(),$this->usuario->validar()["registrar"]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        return response()->json($this->usuario->guardarUsuario($request->all()));
    }

    /*Actualizar Usuario POST*/
    public function actualizar(Request $request){
    }
    /*Datos y estado de usuario POST*/
    public function ver(){
        return response()->json($this->usuario->obtenerUsuario());
    }

    public function eliminar(Request $request){}

    /*Valida si puede usar la api POST*/
    public function auth(){
        return response()->json($this->usuario->api_Auth());
    }

    public function estado(){
        $users = $this->usuario->api_Auth();
        $ubicacion = [];
        if($users["estado"]){
            $persona = $this->usuario->obtenerPersonaDeUsuario($users["userData"]["id"]);
            if(isset($persona)){
                $this->ubicacion = new Ubicaciones();
                $ubicacion = $this->ubicacion->guardar();
            }
            return response()->json(["estado"=>true,"userData"=>$users["userData"],"csrf_token"=>csrf_token(),"ubicacion"=>$ubicacion]);
        }else{
            return response()->json(["estado"=>false]);
        }
    }
}
