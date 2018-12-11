<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request,
    App\Models\Usuarios,
    App\Models\Ubicaciones,
    App\Models\Personas,
    Illuminate\Support\Facades\Validator;

class MainControllers extends Controller
{
    private $usuario = null,$ubicacion = null, $persona = null, $users = null;

    public function __construct()
    {
        $this->usuario = new Usuarios();
        //$this->persona = new Personas();
        //$this->ubicacion = new Ubicaciones();
    }

    public function index(){
        return view('index');
    }

    public function panel(){
        return view('panel');
    }

    public function map(){
        $lat = request()->get("lat");
        $lng = request()->get("lng");
        $map = empty(request()->get("map")) ? "all" : request()->get("map");
        $usu = empty(request()->get("usu")) ? "true" : request()->get("usu");
        if($lat == "null" || $lng == "null"){
            redirect("/panel");
        }
        return view('map',compact('lat','lng',"map","usu"));
    }
}
