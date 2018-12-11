<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TransferException;
use Http\Client\Exception\RequestException;

class Ubicaciones extends Model
{
    //config ip por si se usa desde localhost
    private $ipDefaul = '179.33.147.154';

    private $users = null,$usuario = null, $persona= null, $clien = null;
    private $urlgmaps = 'https://www.googleapis.com/geolocation/v1/geolocate?key=';
    /*Posibles key funcionales google/maps*/
    private $key = [];
    /*Columnas db Ubicacion*/
    protected $fillable = [
        "id", "ip", "ciudad", "region", "region_code",
        "pais", "pais_code", "contiente", "contiente_code",
        "latitud", "longitud", "moneda", "hora", "personId",
        "icono", "codigo_telefono", "codigo_postal", "exactitud"
    ];
    public $timestamps = false;



    public function __construct()
    {
        $this->key = [ "key1" => 'AIzaSyDpHcAz7fytooK39vmES3alQtSFx3EPnAM', "key2" => 'AIzaSyDQKr86dQQBKXZKX6vyda3j7m8pxKAfhJI',
            "key3" => 'AIzaSyCeJZZungKVH7zrlyLgWtFrgLWUVz7-Lmk', "key4" => 'AIzaSyA_6KPQI6k4Ro4kC0th7RE8CSoBWrluI4g',
            "key5" => 'AIzaSyC5Q03V7RkGPYszmJ3AL0Az-gsO3JZiQx4', "key6" => 'AIzaSyDPt7e3kgko0YE_SrmVUcLX8jGBiC-XIWg',
            'key7' => 'AIzaSyBk1XbGUmyKPwQvKxTG4aMOVgelLt3g-KY', 'key8' => 'AIzaSyDzrV8z03TwtNPxqv3emTnqyi4TQBvrHfU',
            'key9' => 'AIzaSyBz_ru_GIxJGJHgx2x5YYq78zM2p97xJqk', 'key10' => 'AIzaSyBm1TszjI2gxHpgv4s9FRe4NbloXC4yEZw',
            'key11' => 'AIzaSyBdJeH0kq3GZDk5GVZz3jWyyX2jLCs5kLo', 'key12' => 'AIzaSyCy1YhYCSFJCwkgbjMCyv6qpiTKbMrIfjs'];

        $this->clien = new Client();
        $this->usuario = new Usuarios();
        $this->persona = new Personas();
        $this->users = $this->usuario->getAuthenticatedUser();
    }

    public function obtenerUbicacion(){
        $persona = $this->usuario->obtenerPersonaDeUsuario($this->users->id);
        $id = $persona->id;
        $ubicacion = $this->persona->obtenerUbicacionDePersona($id);
        return compact('ubicacion','persona');
    }

    public function guardar(){
        $gps = [];
        $ip = request()->ip() == "127.0.0.1" ? $this->ipDefaul :  request()->ip();
        $nowtime = time();
        $ubicacion = $this->all();

        if(isset($ubicacion)){
            $oldtime = !empty($ubicacion->last()) ? $ubicacion->last() : 0;
            if(env("GPS") == 1){
                if($oldtime->hora > 0){
                    //return ((int)$nowtime - (int)$oldtime->hora);
                    if(((int)$nowtime-(int)$oldtime->hora)>60){
                        foreach ($this->key as $key){
                            $data = $this->obtenerUbicacionGoogle($key);
                            if($data["estado"]){
                                $gps = $data["localizacion"];break;
                            }
                        }
                    }
                }
            }else{
                $gps["location"] = ["lat"=>request()->get("lat"),"lng"=>request()->get("lng")];
            }
        }
        $data = $this->registrarUbicacion($gps,$ip);
        return $data;
    }

    public function registrarUbicacion($gps,$ip){
        $data = geoip()->getLocation($ip)->toArray();

        $userData = [
            "id" => $this->users->id,
            "username" => $this->users->username,
            "email" => $this->users->email,
            "rol" => $this->users->rol
        ];

        $personData = $this->usuario->obtenerPersonaDeUsuario($this->users->id);

        $ubicacionData = [
            "ip"=> $data["ip"],
            "ciudad"=> $data["city"],
            "region"=> $data["region"],
            "region_code"=> $data["region_code"],
            "pais"=> $data["country_name"],
            "pais_code"=> $data["country_code"],
            "contiente"=> $data["continent_name"],
            "contiente_code"=> $data["continent_code"],
            "latitud"=> isset($gps["location"]["lat"]) ? $gps["location"]["lat"] : $data["latitude"],
            "longitud"=> isset($gps["location"]["lng"]) ? $gps["location"]["lng"] : $data["longitude"],
            "moneda" => $data["currency"]["code"],
            "hora" => strtotime($data["time_zone"]["current_time"]),
            "personId" =>  $personData["id"],
            "exactitud" => isset($gps["accuracy"]) ? $gps["accuracy"] : '',
            "icono" => $data["flag"],
            "codigo_telefono" => $data["calling_code"],
            "codigo_postal" => $data["postal"]
        ];
        $this->registrar($ubicacionData);
        return compact('userData','personData','ubicacionData');
    }

    public function registrar($data = []){
        $ubicacion = new Ubicaciones();
        $ubicacion->fill($data);
        $ubicacion->save();
        return $ubicacion;
    }

    public function obtenerUbicacionGoogle($key){
        $data["estado"] = false;
        $data["localizacion"] = "";
        try{
            $response = $this->clien->request("POST",$this->urlgmaps.$key);
            $data["localizacion"] = json_decode($response->getBody(), true);
            $data["estado"] = true;
            return $data;
        }
        catch (ClientException $e) {return $data;}
        catch (RequestException $e) {return $data;}
        catch (HttpException $e){return $data;}
        catch (TransferException $e){return $data;}
        catch (ServerException $e){return $data;}
    }


    public function personas(){
        return $this->hasOne(Personas::class,"id","personId");
    }

    public function ubicacionUsuarios(){
        return $this->all();
    }

}
