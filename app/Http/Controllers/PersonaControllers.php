<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Models\Usuarios,
    App\Models\Ubicaciones,
    App\Models\Personas,
    Illuminate\Support\Facades\Validator;

class PersonaControllers extends Controller
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

    public function registrar(Request $request){
        $id = $this->users["userData"]["id"];
        $validator = Validator::make($request->all(), $this->persona->validar()["registrar"]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $userData = [
            "userId" => isset($request->userId) ?? $id,
            "identificacion" => $request->identificacion,
            "primerNombre" => $request->primerNombre,
            "segundoNombre" => $request->segundoNombre,
            "primerApellido" => $request->primerApellido,
            "segundoApellido" => $request->segundoApellido,
        ];
        $personData = $this->persona->registrar($userData);

        if(strlen($request->img)>10){
            $data["img"] = $request->img;
        }
        if(strlen($request->password)>3){
            if($request->password1 == $request->password2){
                $data["password"] = Hash::make($request->password1);
            }
        }
        if(isset($data)){
            $userData = $this->usuario->actualizar($id,$data);
        }
        $estado = true;
        return response()->json(compact('personData','userData','estado'),201);
    }

    public function actualizar(Request $request){
        $id = $this->users["userData"]["id"];
        $validator = Validator::make($request->all(), $this->persona->validar()["actualizar"]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $estado = true;
        $userData = [];
        $personData = $this->persona->actualizar($request->id,
            [
                "primerNombre"=>$request->primerNombre,
                "segundoNombre"=>$request->segundoNombre,
                "primerApellido"=>$request->primerApellido,
                "segundoApellido"=>$request->segundoApellido,
            ]
        );
        if(strlen($request->img)>10){
            $data["img"] = $request->img;
        }
        if(strlen($request->password)>3){
            if($request->password1 == $request->password2){
                $data["password"] = Hash::make($request->password1);
            }
        }
        if(isset($data)){
            $userData = $this->usuario->actualizar($id,$data);
        }
        return response()->json(compact('personData','userData','estado'),201);
    }

    public function eliminar(Request $request){
    }

    public function ver(){
        $personData =$this->usuario->obtenerPersonaDeUsuario($this->users["userData"]["id"]);
       if(isset($personData)){
           $estado = true;
           return response()->json(compact("personData","estado"));
       }else{
           return response()->json(["estado"=>false]);
       }

    }
}
