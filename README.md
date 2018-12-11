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

![img](http://tracking-api.cf:8000/img/test-api/postman/cabezera.png)

- <h3>POST registrar</h3> -
Rest api registrar, registra el usuario
- `http://tracking-api.cf:8000/api/users/registrar`-

        $usuario["registrar"] = [
             'username' => 'required|string|max:255|unique:usuarios',
             'email' => 'required|string|email|max:255|unique:usuarios',
             'password' => 'required'
         ];
 
![img](http://tracking-api.cf:8000/img/test-api/postman/registrar.png)

- <h3>POST Iniciar</h3>-

Rest api Iniciar, este funciona para la creacion de token y validacion del sistema 
- `http://tracking-api.cf:8000/api/users/iniciar`-

        $usuario["iniciar"] = [
             'username' => 'required',
             'password' => 'required'
        ];


![img](http://tracking-api.cf:8000/img/test-api/postman/iniciar.png)


- <h3>GET estado</h3>

Rest api estado, esta funcion devuelve un token y datos del usuario, tambien guarda la ubicacion (sea por ip, google api, html5 api)

- `http://tracking-api.cf:8000/api/users/estado`-
![img](http://tracking-api.cf:8000/img/test-api/postman/estado.png)


- <h3>GET persona</h3>
Rest api Persona, esta funcion devuelve los datos personales de la persona
- `http://tracking-api.cf:8000/api/users/persona`-

![img](http://tracking-api.cf:8000/img/test-api/postman/persona.png)

- <h3>POST guardarPersona</h3>

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
![img](http://tracking-api.cf:8000/img/test-api/postman/guardarPersona.png)

- <h3>POST actualizarPersona</h3>

Rest api actualizarPersona, esta funcion guarda los datos de la persona
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

![img](http://tracking-api.cf:8000/img/test-api/postman/actualizarPersona.png)


- <h3>GET verGps</h3>
Rest api verGps, esta funcion devuelve la ubicaciones del usuario, Es necesario que el usuario tenga una persona creada
- `http://tracking-api.cf:8000/api/users/verGps`-
![img](http://tracking-api.cf:8000/img/test-api/postman/verGps.png)


- <h3>GET ubicaciones</h3>
Rest api ubicaciones, esta funcion devuelve la ubicaciones de todos los usuarios (no se requiere token (opcional)) test -> posible rol 

- `http://tracking-api.cf:8000/api/users/ubicaciones`-
![img](http://tracking-api.cf:8000/img/test-api/postman/ubicaciones.png)


- GET <h3>guardarUbicacion</h3>

Rest api guardarUbicacion, registra la ubicacion donde se encuentra el usuario puede ser 
- [googleApi] -> env("GPS") == 1, si ocurre un fallo en google api esta usa localizacion por ip (no es exacto)
- [HTML5 api geolocalizador] -> env("GPS") <> 1 recibe 2 get, $_GET["lat"], $_GET["lng"]

 `http://tracking-api.cf:8000/api/users/guardarUbicacion`-

 `env("GPS") == 1` -> use google api o localizador por ip
![img](http://tracking-api.cf:8000/img/test-api/postman/guardarUbicacion.png)

`env("GPS") != 1` -> enviar get, (lat y lng) se puede obtener por la API de html5 geolocalizador
![img](http://tracking-api.cf:8000/img/test-api/postman/guardarUbicacion1.png)

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
![img](http://tracking-api.cf:8000/img/test-api/postman/errorToken.png)


<h1>Testear api web</h1>
- link ssl opciona = https://tracking-api.cf<br>

- link http://tracking-api.cf:8000<br>


1. Probar con ssl Web, paso

- <h1>Plantila login</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/plantilla-login.png)
- <h1>Desbloquear SSL</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/debloquear-ssl.png)
- <h1>Usar GPS</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/usar-Gps.png)
- <h1>Activar GPS</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/activar-Geo.png)
- <h1>Registrar Usuario</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/datos-registrar.png)
- <h1>Iniciar Sesíon</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/datos-Login.png)
- <h1>Panel Control</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/plantilla-panel.png)
- <h1>Guardar Datos personas y actualizar (contraseña,img)</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/editar-guardar-persona.png)
- <h1>Panel ubicaciones de usuario</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/panel-geo1.png)
![img](http://tracking-api.cf:8000/img/test-api/web/panel-geo2.png)
- <h1>Ubicacion a revisar por usuario</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/mapa-get.png)
- <h1>Todas las ubicaciones del usuario</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/mapa-usuario.png)
- <h1>Todas las actividades de todos los usuarios</h1>
![img](http://tracking-api.cf:8000/img/test-api/web/mapa-all-usuarios.png)
