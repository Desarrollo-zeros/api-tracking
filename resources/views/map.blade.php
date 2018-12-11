<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, width=device-width" />
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1542186754" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>

</head>
<body>
<div id="map" style="width: 100%; height: 600px; background: grey" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/custom.js"></script>
<script  type="text/javascript" charset="UTF-8" >
    $ = jQuery;
    var validar = false;
    /**
     * Adds markers to the map highlighting the locations of the captials of
     * France, Italy, Germany, Spain and the United Kingdom.
     *
     * @param  {H.Map} map      A HERE Map instance within the application
     */
    function addMarkersToMap(map) {


        @if (isset($lat) && isset($lng))
            var localitations = new H.map.Marker({lat:'{{$lat}}', lng:'{{$lng}}',zoom:10});
            map.addObject(localitations);
            validar = true;
        @elseif(isset($map))
            post($url.ubicaciones,{},'GET').then(data =>{
                for(var i in data){
                    var localitations = new H.map.Marker({lat:data[i].latitud, lng:data[i].longitud});
                    map.addObject(localitations);
                    validar = true;
                }
            });
        @elseif(isset($usu))
            post($url.verGps,{},'GET').then(data =>{
                var ubicacion = data.ubicacion;
                if(ubicacion != null){
                    for(var i in ubicacion){
                        var localitations = new H.map.Marker({lat:ubicacion[i].latitud, lng:ubicacion[i].longitud});
                        map.addObject(localitations);
                    }
                    validar = true;
                }
            });
        @else
            window.location.href = "/";
        @endif
    }
    /**
     * Boilerplate map initialization code starts below:
     */
//Step 1: initialize communication with the platform
    var platform = new H.service.Platform({
        app_id: '{{env('HERE_API_ID')}}',
        app_code: '{{env('HERE_API_KEY')}}',
        useHTTPS: true
    });
    var pixelRatio = window.devicePixelRatio || 1;
    var defaultLayers = platform.createDefaultLayers({
        tileSize: pixelRatio === 1 ? 256 : 512,
        ppi: pixelRatio === 1 ? undefined : 320
    });
    //Step 2: initialize a map - this map is centered over Europe
        if(localStorage.lat == null && localStorage.lng == null){
            var map = new H.Map(document.getElementById('map'),
                defaultLayers.normal.map,{
                    center: {lat:4.5981, lng:-74.0758},
                    zoom: 6,
                    pixelRatio: pixelRatio
                });
        }else{
            var map = new H.Map(document.getElementById('map'),
                defaultLayers.normal.map,{
                    center: {lat:localStorage.lat, lng:localStorage.lng},
                    zoom: 6,
                    pixelRatio: pixelRatio
                });
        }
    //Step 3: make the map interactive
    // MapEvents enables the event system
    // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
    var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
    // Create the default UI components
    var ui = H.ui.UI.createDefault(map, defaultLayers);
    // Now use the map as required..
    // .
    addMarkersToMap(map);
</script>


<script>
    setTimeout(function () {
        if(validar == false){
            window.location.href = "/";
        }
    },3000);
</script>
</body>
</html>
