<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{

    public $timestamps = false;
    protected  $table = 'personas',
        $fillable = ['id','identificacion','primerNombre','segundoNombre','primerApellido','segundoApellido','userId'];
    private $db = null,$usuario=null,$users=null;


    public function __construct()
    {
        $this->db = DB::table($this->table);
    }


    public function obtenerPersona($id){
        return Personas::find($id);
    }

    public function obtenerUbicacionDePersona($id){
        return Personas::find($id)->ubicaciones;
    }


    public function actualizar($id,$data = []){
        $persona = Personas::find($id);
        $persona->update($data);
        $persona->save();
        return $persona;
    }

    public function registrar($data){
        $data["userId"] =
        $persona = new Personas();
        $persona->fill($data)->save();
        return $persona;
    }

    public function usuarios(){
        return $this->hasOne(Usuarios::class,'id','userId');
    }

    public function ubicaciones(){
        return $this->hasMany(Ubicaciones::class,"personId");
    }

    public function validar(){
        $persona["registrar"] = [
            'identificacion' => 'required|string|max:10|min:8|unique:personas',
            'primerNombre' => 'required|string|max:255|min:3',
            'segundoNombre' => 'string|max:255|min:3',
            'primerApellido' => 'required|string|max:255|min:3',
            'segundoApellido' => 'required|string|max:255|min:3',
            'password1' => 'string',
            'password2' => 'string',
            'img' => 'string',
            'userId' => 'required|unique:personas'
        ];

        $persona["actualizar"] = [
            'id' => 'required|int',
            'primerNombre' => 'required|string|max:255|min:3',
            'segundoNombre' => 'string|max:255|min:3',
            'primerApellido' => 'required|string|max:255|min:3',
            'segundoApellido' => 'required|string|max:255|min:3',
            'password1' => 'string',
            'password2' => 'string',
            'img' => 'string'
        ];
        $persona["eliminar"] = [];
        return $persona;
     }

}
