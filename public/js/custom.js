
let post = (url = "",data = {},method = "",csrf_token = '') =>{
    switch (method) {
        case 'POST':
        case 'post':
            return fetch(url, {
                method: method, // or 'PUT'
                headers:{
                    "Content-Type": "application/json; charset=utf-8",
                    'Authorizations' : 'Bearer '+localStorage.authorization,
                },
                redirect: "follow", // manual, *follow, error
                referrer: "no-referrer", // no-referrer, *client
                body: JSON.stringify(data), // body data type must match "Content-Type" header
            }).then(resp => {
                if(resp.status == 500){
                    return false;
                }else{
                    return resp.json();
                }
            });
            break;
        case 'GET':
        case 'get':
            return fetch(url, {
                method: method, // or 'PUT'
                headers:{
                    "Content-Type": "application/json; charset=utf-8",
                    'Authorizations' : 'Bearer '+localStorage.authorization,
                },
                redirect: "follow", // manual, *follow, error
                referrer: "no-referrer", // no-referrer, *client
            }).then(resp => {
                if(resp.status == 500){
                   return false;
                }else{
                    return resp.json();
                }
            });
            break;
    }
};

$url  = localStorage.dataUrl == null ? "" : JSON.parse(localStorage.dataUrl);

function url(){
    setTimeout(function () {
        addurl();
        ulrData();
    }, 15000);
}

function ulrData(){
    localStorage.dataUrl  =  JSON.stringify({
        "iniciar" : localStorage.url+"/api/users/iniciar",
        "registrar" : localStorage.url+"/api/users/registrar",
        "estado" : localStorage.url+"/api/users/estado",
        "panel" : localStorage.url1+"/panel", //no api
        "map" : localStorage.url1+"/map", //no api
        "persona" : localStorage.url+"/api/users/persona",
        "guardarPersona" : localStorage.url+"/api/users/guardarPersona",
        "actualizarPersona" : localStorage.url+"/api/users/actualizarPersona",
        "verGps" : localStorage.url+"/api/users/verGps",
        "ubicaciones" : localStorage+"api/users/ubicaciones"
    });

}


function showPosition(position) {
    localStorage.lat = position.coords.latitude;
    localStorage.lng = position.coords.longitude;
}

var authorizacion = () => {
    try{
        if(localStorage.authorization == null && window.location.href.split("#")[0] == $url.panel && window.location.href.split("#")[0] == $url.map){
            window.location.href = "/";
        }
        if(localStorage.authorization != null && window.location.href.split("#")[0] == $url.panel){
            /*if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }*/
            post($url.estado,{},'GET').then(data => {
                if(!data.estado){
                    window.location.href = "/";
                }
                //$("#userId").val(data.userData.id);
                $("#nameUser").html(data.userData.username);
                $("#emailUser").html(data.userData.email);
                $("#imgUser").attr("src",data.userData.img);
                data.userData.token = localStorage.authorization;
                $('.account').html(prettyPrintJson.toHtml(data.userData));
            });
        }

        if(localStorage.authorization != null &&
            window.location.href.split("#")[0] != $url.panel &&
            window.location.href.split("?")[0] != $url.panel &&
            window.location.href.split("/?")[0] != $url.panel &&
            window.location.href.split("#")[0] != $url.map &&
            window.location.href.split("?")[0] != $url.map &&
            window.location.href.split("/?")[0] != $url.map){
            post($url.estado,{},'GET').then(data => {
                if(data.estado){
                    window.location.href = $url.panel;
                }
            });
        }


    }
    catch(e){return false;}
};


function loaderPerson() {
    post($url.persona,{"id":$("#userId").val()},'GET',).then(data => {
        if(data.estado == true){
            $("#personId").val(data.personData.id);
            $("#document").val(data.personData.identificacion);
            $("#first_name").val(data.personData.primerNombre);
            $("#second_name").val(data.personData.segundoNombre);
            $("#first_surname").val(data.personData.primerApellido);
            $("#second_surname").val(data.personData.segundoApellido);
            $("#userId").val(data.personData.userId);
            $("#ViewimgPerson").attr("src",$("#imgUser").attr("src"));
        }else{
            $( "#document" ).prop( "disabled", false );
        }
    });
}


function loaderTableuser(){
    post($url.verGps,{},'GET').then(data =>{
        var string = '';
        var ubicacion = data.ubicacion;
        for(var i in ubicacion){
            var pais = '<td><img class="img-circle img-responsive" src="'+ubicacion[i].icono+'"/> <span class="fa fa-arrow-right"> '+ubicacion[i].pais+'</span></td>';
            string += '<tr>';
            string += '<th scope="row">'+ubicacion[i].id+'</th>';
            string += '<td>'+ubicacion[i].ip+'</td>';
            string += pais;
            string += '<td>'+ubicacion[i].moneda+'</td>';
            string += '<td>'+ubicacion[i].latitud+'</td>';
            string += '<td>'+ubicacion[i].longitud+'</td>';
            string += '<td><a target="_blank" href="/map/?lat='+ubicacion[i].latitud+'&lng='+ubicacion[i].longitud+'" class="btn btn-circle btn-info btn-sm"><span class="fa fa-map-marker">Ver Mapa</span></a></td>';
            string += '</tr>';
        }
        $("#tableUserData").html(string);
    });
}

var validatePassword = () =>{
    var element1 = $("#password1")[0];
    var element2 = $("#password2")[0];
    var btn = $("#btnSavePerson")[0];
    if($("#personId").val.length>4){
        if($("#chekChangePassword").prop('checked')){
            if($("#password1").val() != $("#password2").val()) {
                element1.setCustomValidity('Contraseña no son iguales.');
                element2.setCustomValidity('Contraseña no son iguales.');
                btn.disabled = true;
            }else{
                element1.setCustomValidity('');
                element2.setCustomValidity('');
                btn.disabled = true;
            }
        }
    }else{
        if($("#password1").val() != $("#password2").val()) {
            element1.setCustomValidity('Contraseña no son iguales.');
            element2.setCustomValidity('Contraseña no son iguales.');
            btn.disabled = true;
        }else{
            element1.setCustomValidity('');
            element2.setCustomValidity('');
            btn.disabled = false;
        }
    }
};


$("#chekChangePassword").change(function(){
    if($("#chekChangePassword").prop('checked')){
        $( "#password1" ).prop( "disabled", false );
        $( "#password2" ).prop( "disabled", false );
    }else{
        $( "#password1" ).prop( "disabled", true );
        $( "#password2" ).prop( "disabled", true );
    }
});

$("#formPersons").on("submit",function (form) {
    form.preventDefault();

    var obj = new Object();
    obj.id = "";
    if($("#document").val() != ""){
        obj.identificacion = $("#document").val();
    }
    if($("#first_name").val() != ""){
        obj.primerNombre = $("#first_name").val();
    }
    if($("#second_name").val() != ""){
        obj.segundoNombre = $("#second_name").val();
    }
    if($("#first_surname").val() != ""){
        obj.primerApellido = $("#first_surname").val();
    }
    if($("#second_surname").val() != ""){
        obj.segundoApellido = $("#second_surname").val();
    }
    if ($("#imgFile").val() != ""){
        obj.img = $("#imgPerson").val();
    }

    if($("#password1").val() != "" && $("#password1").val() == $("#password2").val()){
        obj.password1 = $("#password1").val();
        obj.password2 = $("#password2").val();
    }else{
        validatePassword();
    }
    obj.userId = $("#userId").val();
    if($("#personId").val() == ""){
        post($url.guardarPersona,obj,'POST').then(data => {
            if(data.estado == true){
                $.notify("Datos guardados con exito","success")
            }else{
                $.notify("Revisa los datos, no se permiten campos vacios","error")
            }
        });
    }else{
        obj.id = $("#personId").val();
        post($url.actualizarPersona,obj,'POST').then(data => {
            if(data.estado == true){
                $.notify("Datos Actualizados con exito","success")
            }else{
                $.notify("Revisa los datos, no se permiten campos vacios","error")
            }
        });
    }
});

function encodeImagetoBase64(element) {
    var file = element.files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        $("#imgPerson").val(reader.result);
    }
    reader.readAsDataURL(file);
}

function archivo(evt) {
    var files = evt.target.files; // FileList object

    //Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
        //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }

        var reader = new FileReader();

        reader.onload = (function(theFile) {
            return function(e) {
                // Creamos la imagen.
                $("#ViewimgPerson").attr("src",e.target.result);
                $("#imgUser").attr("src",e.target.result)
            };
        })(f);

        reader.readAsDataURL(f);
    }
}
$("#imgFile").change(function(evt){
    archivo(evt);
});
