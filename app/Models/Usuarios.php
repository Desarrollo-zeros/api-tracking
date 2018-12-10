<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuarios extends Authenticatable implements JWTSubject
{
    public $timestamps = false,$table ='usuarios',$hidden=['password'],
        $fillable = ['username','email','password','rol','img'];

    private $db = null,$ubicacion;

    public function __construct()
    {
        $this->db = DB::table($this->table);
    }


    public function api_Auth(){
        try {
            if(!$user = JWTAuth::parseToken()->authenticate()){return ["estado"=>false];}
        }
        catch (JWTException $e) {return ["estado"=>false];}
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {return ["estado"=>false];}
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {["estado"=>false];}
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {return ["estado"=>false];}
        return ["estado"=>true,"userData"=>$user];
        //@return estado + datos usuarios
    }

    /*obtengo los datos de un usuario*/
    public function filtrarUsuario($user){
        return filter_var($user, FILTER_VALIDATE_EMAIL) ?
            $this->db->where("email",$user)->get()[0] :
            $this->db->where("username",$user)->get()[0];
    }

    //validate token
    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {return [['user_not_found'], 404];}
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {return [['token_expired'], $e->getStatusCode()];}
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {return [['token_invalid'], $e->getStatusCode()];}
        catch (Tymon\JWTAuth\Exceptions\JWTException $e) {return [['token_absent'], $e->getStatusCode()];}
        return $user;
    }

    public function auth($data = []){
        try {
            if (!$token = JWTAuth::attempt($data)) {
                return [['error' => 'invalid_credentials'], 400];
            }
        }
        catch (JWTException $e) {return [['error' => 'could_not_create_token'], 500];}
        $userData = $this->filtrarUsuario($data["username"]);
        unset($userData->password);
        return compact('userData','token');
    }

    public function obtenerUsuario(){
        $user = $this->api_Auth();
        if($user["estado"]) {
            return [Usuarios::find($user["userData"]->id),"estado"=>true];
        }else{
            return ["estado"=>false];
        }
    }

    public function obtenerPersonaDeUsuario($id){return Usuarios::find($id)->personas;}

    public function actualizar($id,$data=[]){
        $usuario  = Usuarios::find($id);
        if(isset($usuario)){
            $usuario->update($data);
            $usuario->save();
            return $usuario;
        }else{
            return [];
        }
    }




    public function registrar($data = []){
        $usuario = new Usuarios();
        $usuario->fill($data)->save();
        return $usuario;
    }

    public function guardarUsuario($data = []){
        $data['password'] = Hash::make($data['password']);
        $userData = $this->registrar($data);
        $token = JWTAuth::fromUser($userData);
        return compact('userData','token');
    }

    /*implements JWTSubject*/
    public function getJWTIdentifier(){return $this->getKey();}
    public function getJWTCustomClaims(){return [];}

    /*Relacion De persona a usuario*/
    public function personas(){return $this->hasOne(Personas::class,"userId");}


    public function obetnerToken($data = []){
        try {
            if (! $token = JWTAuth::attempt($data)) {
                return [['error' => 'invalid_credentials'],400];
            }else{
                return $token;
            }
        } catch (JWTException $e) {
            return [['error' => 'could_not_create_token'], 500];
        }
    }

    public function validar(){
        $usuario["registrar"] = [
            'username' => 'required|string|max:255|unique:usuarios',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required'
        ];
        $usuario["iniciar"] = [
            'username' => 'required',
            'password' => 'required'
        ];
        $usuario["actualizar"] = [
            //'username' => 'required|string|max:255|unique:usuarios',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required'
        ];
        return $usuario;
    }
}
