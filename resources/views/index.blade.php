<!DOCTYPE html>
<html lang="en">
<head>
    <title> System | 	Login
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app_login.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/pretty-print-json@0.0/dist/pretty-print-json.css>
    <script src="https://cdn.jsdelivr.net/npm/pretty-print-json@0.0/dist/pretty-print-json.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/notify.min.js"></script>
</head>
<body class="">
<div class="login-page">
    <div class="row">
        <div class="col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
            <img src="http://ani-laravel.strapui.com/images/flat-avatar.png" class="user-avatar" />
            <h1>Iniciar Sesión</h1>

            <form role="form" id="formLogin">
                <div class="form-content" >
                    <div class="form-group">
                        <input type="text" class="form-control input-underline input-lg" id="username" placeholder="Email o Username" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control input-underline input-lg" id="password" placeholder="Contraseña" required="required">
                    </div>
                </div>
                <pre class="account" style="background: #000000!important; height: auto!important; width: auto!important;"></pre>
                <input type="submit" class="btn btn-white btn-outline btn-lg btn-rounded progress-login" value="Iniciar Sesion" />
                &nbsp;
                <a href="#" id="btnRegister" class="btn btn-white btn-outline btn-lg btn-rounded">Register</a>
            </form>

            <form role="form" id="formRegister" style="display: none">
                <div class="form-content" >
                    <div class="form-group">
                        <input type="text" class="form-control input-underline input-lg" id="username1" name="username1" placeholder="Username" required="required" minlength="5" maxlength="10">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control input-underline input-lg" id="email1" name="email1" placeholder="Email" required="required"  minlength="5" maxlength="50">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control input-underline input-lg" id="password1" name="password1" placeholder="Contraseña" required="required"  minlength="5" maxlength="10">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control input-underline input-lg" id="password2"  name="password2" placeholder="Confirme Contraseña" required="required" onkeydown="passwordMatch()"  minlength="5" maxlength="10">
                    </div>
                </div>
                <pre class="account" style="background: #000000!important; height: auto!important; width: auto!important;"></pre>
                <input type="submit" id="btnFormRegister" disabled="disabled" class="btn btn-white btn-outline btn-lg btn-rounded progress-login" value="Registrar" />
                &nbsp;
                <a href="#" id="btnLogin" class="btn btn-white btn-outline btn-lg btn-rounded">Volver A login</a>
            </form>

        </div>
    </div>
</div>
</body>



<script>


    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert()
                alert("Usuario negó la solicitud de Geolocalización, para gestionar la ubicacion vuelva a cargar la pagina y permita conocer su ubicacion");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("La información de ubicación no está disponible.");
                break;
            case error.TIMEOUT:
                alert("La solicitud para obtener la ubicación del usuario ha caducado.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    function showPosition(position) {
        localStorage.lat = position.coords.latitude;
        localStorage.lng= position.coords.longitude;
    }

    $(document).ready(function () {
        addurl();url();ulrData();
        $url = JSON.parse(localStorage.dataUrl);

        setTimeout(function () {
            if('{{env('GPS')}}' === 0){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition,showError);
                }
            }
        },1000);

        var lat = localStorage.lat != null ? localStorage.lat: null;
        var lng = localStorage.lng != null ? localStorage.lng: null;
        var uri = "/?lat="+lat+"&lng="+lng;
        post($url.estado,{},'GET').then(data => {
            if(data.estado){
                window.location.href = $url.panel+uri;
            }
        });
    });

    function addurl() {
        if(window.location.href != '{{env('APP_URL_API')}}'){
            localStorage.url = '{{env('APP_URL_API')}}';
        }else{
            localStorage.url = '{{request()->url()}}';
        }
    }

    $("#btnRegister").click(function () {
        $("#formLogin").css("display","none");
        $("#formRegister").css("display","block");
    });

        $("#btnLogin").click(function () {
            $("#formRegister").css("display","none");
        $("#formLogin").css("display","block");
    });

    function passwordMatch() {
        var password, password2,btnFormRegister;

        password = document.getElementById('password1');
        password2 = document.getElementById('password2');
        btnFormRegister = document.getElementById('btnFormRegister');

        password.onchange = password2.onkeyup = passwordMatch;

        if(password.value !== password2.value) {
            btnFormRegister.disabled  = true;
            password2.setCustomValidity('Las contraseñas no coinciden.');
        }
        else{
            btnFormRegister.disabled  = false;
            password2.setCustomValidity('');
        }
    }

    $("#formLogin").on("submit",function (form) {
        form.preventDefault();
        var data = {"username":$('#username').val(),"password":$('#password').val()};

        var lat = localStorage.lat != null ? localStorage.lat: null;
        var lng = localStorage.lng != null ? localStorage.lng: null;
        var uri = "?lat="+lat+"&lng="+lng;

        post($url.iniciar,data,'POST').then(data => {
            $('.account').html(prettyPrintJson.toHtml(data));
            if(data.token.length > 1){
                localStorage.authorization = data.token;
                document.cookie = "token="+data.token;
                $.notify("logearas en 5 segundos","success");
                setTimeout(function () {
                    setTimeout(window.location.href = $url.panel+uri, 5000);
                }, 5000);
            }
        });
    });


    $("#formRegister").on("submit",function (form) {
        form.preventDefault();
        var data = {"username":$('#username1').val(),"password":$('#password1').val(),"email":$('#email1').val()};
        post($url.registrar,data,'POST').then(data => {
            $('.account').html(prettyPrintJson.toHtml(data));
            try{if(data.token.length > 1){
                localStorage.authorization = data.token;
            }}catch(e){$.notify(data)}
        });
    });


</script>

</html>

