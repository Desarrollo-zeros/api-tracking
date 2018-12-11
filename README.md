Bueno aca, tratare de explicar que hice.
 1. Primero, descargue el instalador de Laravel usando Compose `composer global require laravel/installer`
 2. Creo el proyecto con composer global `composer create-project --prefer-dist laravel/laravel api-traking`
 3. voy a la carpeta donde se creo el proyecto y hago un update `composer update` esto actualizara todos los archivos a la version de php que usas 
# Comenzemos. 

Como instalar?

1- `git clone https://github.com/Desarrollo-zeros/api-tracking`
2- `cd api-tracking` buscarlo en la carpeta
3- `composer update` -> https://getcomposer.org/download/


**Librerias** 

1.JWT como instalar? -> `https://blog.pusher.com/laravel-jwt/` leamos un poco

2.geoip2 como instalar? -> `http://lyften.com/projects/laravel-geoip/doc/` 

***
APis
***

- actualizarPersona: "http://tracking-api.cf:8000/api/users/actualizarPersona" -> requiere token
- estado: "http://tracking-api.cf:8000/api/users/estado" -> busca token -> Metodo["GET"]
- guardarPersona: "http://tracking-api.cf:8000/api/users/guardarPersona" -> requiere token -> Metodo["POST"]
- iniciar: "http://tracking-api.cf:8000/api/users/iniciar" -> crea token -> Metodo["POST"]
- map: "http://tracking-api.cf:8000/map" no api -> Metodo["GET"]
- panel: "http://tracking-api.cf:8000/panel" no api -> -> Metodo["GET"]
- persona: "http://tracking-api.cf:8000/api/users/persona" -> requiere token -> Metodo["GET"]
- registrar: "http://tracking-api.cf:8000/api/users/registrar"  -> requiere token -> Metodo["POST"]
- ubicaciones: "http://tracking-api.cf:8000/api/users/ubicaciones"  -> registro sin toekn -> Metodo["GET"]
- verGps: "http://tracking-api.cf:8000/api/users/verGps"  -> requiere token -> Metodo["GET"]
- guardarUbicacion: "http://tracking-api.cf:8000/api/users/guardarUbicacion"  -> requiere token -> Metodo["GET"]

Route api `

- Route::post('users/iniciar', 'UsuarioControllers@iniciar'); //no requiere token
- Route::post('users/registrar', 'UsuarioControllers@registrar'); //no requiere token

- Route::get('users/ubicaciones',function (){return response()->json(\Illuminate\Support\Facades\DB::table("ubicaciones")->get()); //no requiere token});

- Route::group(['middleware' => ['jwt.verify']], function() { //requiere toekn`
    - Route::get('users/estado', 'UsuarioControllers@estado');
    - Route::get('users/persona','PersonaControllers@ver');
    - Route::post('users/guardarPersona','PersonaControllers@registrar');
    - Route::post('users/actualizarPersona','PersonaControllers@actualizar');
    - Route::get('users/verGps',"UbicacionControllers@ver");
    - Route::get('users/guardarUbicacion','UbicacionControllers@guardar');
- });
`

Header 
` "Content-Type": "application/json; charset=utf-8",
  "Authorizations" : "Bearer token"`


Rest api registrar, registra el usuario
- `http://tracking-api.cf:8000/api/users/registrar`-

        $usuario["registrar"] = [
             'username' => 'required|string|max:255|unique:usuarios',
             'email' => 'required|string|email|max:255|unique:usuarios',
             'password' => 'required'
         ];
 
- POST registrar -
- <img> -- <img>

Rest api Iniciar, este funciona para la creacion de token y validacion del sistema 
- `http://tracking-api.cf:8000/api/users/iniciar`-

        $usuario["iniciar"] = [
             'username' => 'required',
             'password' => 'required'
        ];

- POST Iniciar-
- <img> -- <img>

Rest api estado, esta funcion devuelve un token y datos del usuario, tambien guarda la ubicacion (sea por ip, google api, html5 api)

- `http://tracking-api.cf:8000/api/users/estado`-
- GET estado
- <img> -- <img>

Rest api Persona, esta funcion devuelve los datos personales de la persona
- `http://tracking-api.cf:8000/api/users/persona`-
- GET persona
- <img> -- <img>


Rest api guardarPersona, esta funcion guarda los datos de la persona, solo se puede crear una persona por usuario, tambien 
- `http://tracking-api.cf:8000/api/users/guardarPersona`-

        $persona["registrar"] = [
            'identificacion' => 'required|string|max:10|min:8|unique:personas',
            'primerNombre' => 'required|string|max:255|min:3',
            'segundoNombre' => 'string|max:255|min:3',
            'primerApellido' => 'required|string|max:255|min:3',
            'segundoApellido' => 'required|string|max:255|min:3',
            'password1' => 'string',//opcional para actualizar
            'password2' => 'string', //opcional para actualizar
            'img' => 'string', //imagen encriptada base64 opcional
            'userId' => 'required|unique:personas'
        ];
- POST guardarPersona
- <img> -- <img>



Rest api guardarPersona, esta funcion guarda los datos de la persona
- `http://tracking-api.cf:8000/api/users/actualizarPersona`-

        $persona["actualizar"] = [
            'id' => 'required|int', //tambien se extra de token
            'primerNombre' => 'required|string|max:255|min:3',
            'segundoNombre' => 'string|max:255|min:3',
            'primerApellido' => 'required|string|max:255|min:3',
            'segundoApellido' => 'required|string|max:255|min:3',
            'password1' => 'string',
            'password2' => 'string',
            'img' => 'string'
        ];
- POST guardarPersona
- <img> -- <img>

Rest api verGps, esta funcion devuelve la ubicaciones del usuario, Es necesario que el usuario tenga una persona creada
- `http://tracking-api.cf:8000/api/users/verGps`-
- GET persona
- <img> -- <img>


Rest api ubicaciones, esta funcion devuelve la ubicaciones de todos los usuarios (no se requiere token (opcional)) test -> posible rol 

- `http://tracking-api.cf:8000/api/users/ubicaciones`-
- GET persona
- <img> -- <img>

Rest api guardarUbicacion, registra la ubicacion donde se encuentra el usuario puede ser 
- [googleApi] -> env("GPS") == 1, si ocurre un fallo en google api esta usa localizacion por ip (no es exacto)
- [HTML5 api geolocalizador] -> env("GPS") <> 1 recibe 2 get, $_GET["lat"], $_GET["lng"]

 `http://tracking-api.cf:8000/api/users/guardarUbicacion`-

- GET persona
- <img> -- <img>


- Como se valida si el token existe-> la forma como se validan datos son extendidas por JWT al Middleware Authenticate, por lo tanto esta valida el hash y usuario creado.

en config/auth.php, se modifica para que las autentificaciones sean realizadas a la tabla Usuarios,

`providers => users` cambiar el campo model => 'nombre de la clase donde se encuentra el usuario' `TablaUsuario`

`'model' => App\Models\Usuarios::class, // `tabla usuario``

config/jwt.php

JWT time to live

- `'ttl' => env('JWT_TTL', 60)` tiempo en minuto
- error token 
[
    "status"=>"Token is Invalid"
]

