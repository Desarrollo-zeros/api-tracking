<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Api trackers</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body>
<div class="page">
    <!-- Main Navbar-->
    <header class="header">
        <nav class="navbar">
            <!-- Search Box-->
            <div class="search-box">
                <button class="dismiss"><i class="icon-close"></i></button>
                <form id="searchForm" action="#" role="search">
                    <input type="search" placeholder="What are you looking for..." class="form-control">
                </form>
            </div>
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <!-- Navbar Header-->
                    <div class="navbar-header">
                        <!-- Navbar Brand --><a href="index.html" class="navbar-brand d-none d-sm-inline-block">
                            <div class="brand-text d-none d-lg-inline-block"><span>Api </span><strong> Trackers</strong></div>
                            <div class="brand-text d-none d-sm-inline-block d-lg-none"><strong>BD</strong></div></a>
                        <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
                    </div>
                    <!-- Navbar Menu -->
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <!-- Search-->
                        <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="icon-search"></i></a></li>
                        <!-- Notifications-->
                        <li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell-o"></i><span class="badge bg-red badge-corner">12</span></a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-envelope bg-green"></i>You have 6 new messages </div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-upload bg-orange"></i>Server Rebooted</div>
                                            <div class="notification-time"><small>4 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item">
                                        <div class="notification">
                                            <div class="notification-content"><i class="fa fa-twitter bg-blue"></i>You have 2 followers</div>
                                            <div class="notification-time"><small>10 minutes ago</small></div>
                                        </div></a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong>view all notifications                                            </strong></a></li>
                            </ul>
                        </li>
                        <!-- Messages                        -->
                        <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope-o"></i><span class="badge bg-orange badge-corner">10</span></a>
                        </li>
                        <!-- Languages dropdown    -->
                        <li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img src="img/flags/16/co.png" alt="Español"><span class="d-none d-sm-inline-block">Español</span></a>
                            <ul aria-labelledby="languages" class="dropdown-menu">
                                <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="img/flags/16/AR.png" alt="Español" class="mr-2">Español</a></li>
                                <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="img/flags/16/FR.png" alt="Ingles" class="mr-2">Ingles</a></li>
                            </ul>
                        </li>
                        <!-- Logout    -->
                        <li class="nav-item"><a href="#" onclick="localStorage.authorization = null; window.location.href ='/'; deleteCookie('token');" class="nav-link logout"> <span class="d-none d-sm-inline">Cerrar Sesíon</span><i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
            <!-- Sidebar Header-->
            <div class="sidebar-header d-flex align-items-center">
                <div class="avatar"><img id="imgUser" src="" alt="..." class="img-fluid rounded-circle"></div>
                <div class="title">
                    <input id="userId" type="hidden">
                    <h1 class="h4" id="nameUser"></h1>
                    <p id="emailUser"></p>
                </div>
            </div>
            <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
            <ul class="list-unstyled">
                <li class="active"><a href="#"> <i class="icon-home"></i>Inicio </a></li>
                <li><a href="#formPersons" onclick="$('#dashboard-Info').css('display','block');$('#tablaUsers').css('display','none');loaderPerson()"> <i class="fa fa-info"></i>Informacion Personal </a></li>
                <li><a href="#tablaUsers" onclick="$('#dashboard-Info').css('display','none');$('#tablaUsers').css('display','block');loaderTableuser()"> <i class="fa fa-google-plus-square"></i>Localizacíones </a></li>
                <li><a href="/map?usu=true" target="_blank"> <i class="fa fa-google-plus-square"></i>Mostrar Actividad Mapa </a></li>
                <li><a href="#" onclick="localStorage.authorization = null; window.location.href ='/';deleteCookie('token');"> <i class="fa fa-sign-out"></i>Cerrar Sesíon </a></li>
            </ul>
        </nav>
        <div class="content-inner">
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">Dashboard</h2>
                </div>
            </header>
            <!-- Dashboard Counts Section-->


            <section class="tables">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="work-amount card">
                                <div class="card-body" id="">
                                    <pre class="account" style="background: #000000!important; height: auto!important; width: auto!important;color:#FFFFFF"></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="dashboard-Info" style="display: none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="work-amount card">
                                <div class="card-close">
                                    <div class="dropdown">
                                        <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                        <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <h2 class="h2"><small>Informacion Personal</small></h2>
                                            <div class="card-body">
                                                <form id="formPersons">
                                                    <div class="form-group row">
                                                        <div class="form-group col-md-4">
                                                            <input type="file" id="imgFile" name="imgFile[]" onchange="encodeImagetoBase64(this)"/>
                                                            <input type="hidden" id="imgPerson" name="imgPerson">
                                                            <input type="hidden" id="personId">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <img class="img-responsive img-thumbnail" style="position:relative; bottom:12px!important;" id="ViewimgPerson" width="100">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Documento</label>
                                                            <input disabled="disabled" id="document" name="document" value="" type="number" placeholder="Documento" class="form-control" required="required" maxlength="10" minlength = "8" pattern=".{8}|.{10}">
                                                            <input type="hidden" id="userId" name="userId" value="">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label" >Primer Nombre</label>
                                                            <input id="first_name" name="first_name" type="text" placeholder="Primer Nombre" value=""  class="form-control" required="required"pattern="[A-Za-z]{0,10}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label" id>Segundo Nombre</label>
                                                            <input id="second_name" name="second_name" type="text" placeholder="Segundo Nombre" value=""  class="form-control" required="required" pattern="[A-Za-z]{0,10}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Primer Apellido</label>
                                                            <input id="first_surname" name="first_surname" type="text" placeholder="Primer Apellido" value=""  class="form-control" required="required" pattern="[A-Za-z]{0,10}">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label">Segundo Apellido</label>
                                                            <input id="second_surname" name="second_surname"  type="text" placeholder="Segundo Apellido" value=""  class="form-control" required="required" pattern="[A-Za-z]{0,10}">
                                                        </div>

                                                        <div class="form-group col-md-6">

                                                        </div>
                                                        <div class="form-group col-md-6 pw">
                                                            <label class="control-label">Contraseña </label>
                                                            <input type="password"  disabled id="password1" name="password1" placeholder="Contraseña" class="form-control" required="required">
                                                        </div>

                                                        <div class="form-group col-md-6 pw">
                                                            <label class="control-label">Repite La Contraseña </label>
                                                            <input type="password" disabled id="password2" name="password2" placeholder="Repite La Contraseña" class="form-control" required="required" onkeydown="validatePassword()" onchange="return validatePassword()">
                                                        </div>

                                                        <div class="form-group col-md-6 text-left">
                                                            <label class="control-label">Cambiar Contraseña?</label>
                                                            <input type="checkbox" id="chekChangePassword" >
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <input type="submit" id="btnSavePerson" value="Guardar Datos" class="form-control btn btn-info btn-sm">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <section class="tables" id="tablaUsers" style="display: none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-close">
                                    <div class="dropdown">
                                        <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                        <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                                    </div>
                                </div>
                                <div class="card-header d-flex align-items-center">
                                    <h3 class="h4 text-center">Mis Localizaciones</h3>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Direccion IP</th>
                                                <th>Pais</th>
                                                <th>Moneda</th>
                                                <th>latitud</th>
                                                <th>Longitud</th>
                                                <th>Fecha</th>
                                                <th>Ver Donde estuve</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tableUserData">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Page Footer-->
            <footer class="main-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>Zeros.com &copy; 2019</p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p>Design by <a href="https://bootstrapious.com/admin-templates" class="external">Api - Trackers (Zeros)</a></p>
                            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
<!-- JavaScript files-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $ = jQuery;
</script>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper.js/umd/popper.min.js"> </script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<!-- Main File-->
<script src="js/front.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pretty-print-json@0.0/dist/pretty-print-json.min.js"></script>
<script src="js/notify.min.js"></script>
<script src="js/custom.js"></script>
<script>


    function addurl() {
        if(window.location.href != '{{env('APP_URL_API')}}'){
            localStorage.url = '{{env('APP_URL_API')}}';
        }else{
            localStorage.url = '{{request()->url()}}';
        }
    }
    $(document).ready(function () {
        addurl();url();urlData();
        $url = JSON.parse(localStorage.dataUrl);
        if(window.location.href.split("?")[1] != null){
            var s = window.location.href.split("?")[1].split("&");
            localStorage.lat = s[0].split("lat")[1].replace("=","");
            //localStorage.lat = localStorage.lat.replace("=","");
            localStorage.lng = s[1].split("lng")[1].replace("=","");
            //localStorage.lng = localStorage.lng.replace("=","");
        }
        var gps = window.location.href.split("?")[1] == null ? '' : "?"+window.location.href.split("?")[1];

        post($url.estado+gps,{},'GET').then(data => {
            if(!data.estado){
                window.location.href = "{{env("APP_URL_API_SSL")}}";
            }else{
                //$("#userId").val(data.userData.id);
                $("#nameUser").html(data.userData.username);
                $("#emailUser").html(data.userData.email);
                $("#imgUser").attr("src",data.userData.img);
                data.userData.token = localStorage.authorization;
                $('.account').html(prettyPrintJson.toHtml(data.userData));
            }
        });
    });

</script>

</body>
</html>
