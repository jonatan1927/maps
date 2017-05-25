<!DOCTYPE html>
<html ng-app="AngularGoogleMap" >
    <head>
        <meta charset="utf-8">
        <title>AngularJS / Google Maps Tutorial</title>

        <link href="css/style.css" rel="stylesheet"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>

        <!-- AngularJS -->
        <script src="js/lib/angularjs.min.js?v=1.2.26"></script>

        <!-- Google Maps -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAupo8GprMWsfAiJBwIynYI0SHXO71Or-c"></script>

        <!-- angular-goole-maps -->
        <script src="js/lib/lodash.underscore.min.js?v=2.4.1"></script>
        <script src="js/lib/angular-google-maps.min.js?v=1.2.2"></script>

        <!-- Custom angular module -->
        <script src="js/map.js?v=1.0"></script>
    </head>
    <body ng-controller="MapCtrl">
        <?php
        session_start();
        session_destroy();
        $ao = new ArrayObject();
        ?>
        <h1></h1>
        <div class="map_container" >
            <google-map center="map.center" zoom="map.zoom" draggable="true" options="map.options" control="map.control">
                <markers models="map.markers" coords="'self'" options="'options'" isLabel='true'>
                </markers>
            </google-map>
        </div>  
        <div class="controls">
            <h3>Geolocalizacion</h3>
            <p>
                <button ng-click="addCurrentLocation()">Geolocalizacion</button>                
            </p>
            <!--            <h3>Address search</h3>
                        <p>
                            <input type="text" placeholder="Address. i.e: Concha Espina 1, Madrid" ng-model="address" style="width: 210px"/>
                            <button ng-click="addAddress()">Look up!</button>    
                        </p>
                        <p>
                        <h3>Ingrese sus coordenadas</h3>
                    </p>-->
            <!--
                        <input type = "file" file-model = "myFile"/>
                        <button ng-click = "addPointsFile()">upload me</button>-->
            <?php
            if (isset($_SESSION['usuario'])) {
                $ppt = $_SESSION['usuario'];
                ?>
                <input type="hidden" name="latitud" id="latitud" value='<?php
                foreach ($ppt as $value) {
                    echo $value[0] . ';';
                }
                ?>' id="latitud">
                <input type="hidden" name="longitud" id="longitud" value='<?php
                foreach ($ppt as $value) {
                    echo $value[1] . ';';
                }
                ?>' id="longitud">
                <button ng-click="addPointsFile()" id="adicion">Adiconar puntos</button>
            <?php }
            ?>       
            <div id="america">
                <form action="php/upload.php" method="post" enctype="multipart/form-data">
                    Seleccione su archivo excel:
                    <input type="file" name="file" id="file">
                    <input type="submit" value="Guardar registros" id="guardar">
                </form>

            </div>
                <a href="archivo/jvv1.xls">Descargar archivo de prueba</a>
            <script>
                        $(function () {
                            $("#adicion").click(function () {
                                $("#adicion").hide();
                                $("#america").show();

                            });
                            if ($('#adicion').is(":visible")) {
                                $("#america").hide();
                            } else {
                                $("#america").show();
                            }
                        });
            </script>        
    </body>
</html>
