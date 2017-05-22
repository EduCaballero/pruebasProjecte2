<html>
    <head>
        <script src="js/src/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfITkskFnkQFXkgSbMT-AoPXCx9_yHoXw&region=GB"></script>
        <script src="js/src/gmap3.min.js" type="text/javascript"></script>
        <script src="slick/slick.min.js" type="text/javascript"></script>
        <script src="js/src/gmap.js" type="text/javascript"></script>
        <link href="slick/slick.css" rel="stylesheet" type="text/css"/>
        <link href="slick/slick-theme.css" rel="stylesheet" type="text/css"/>
        <link href="css/gmap.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'bbdd.php';
        $concertID = $_GET["paso"]; //id concierto
        $city = $_GET["paso2"]; //ciudad 

        $idLocal = idLocal($concertID);
        $direccion = address($idLocal) . ", " . $city;
        echo $direccion;
        ?>
        <div id="map"></div>
        <script>
            $(document).ready(function () {
                $('#map').gmap3({
                    zoom: 6
                })
                        .infowindow({})
                        .marker([
                            {address: "<?php echo $direccion ?>", data: "<h3><?php echo $direccion ?></h3><div>"}
                        ])
                        .on('click', function (marker) {  //Al clicar obrim una finestra sobre la marca i hi insertem el data de la marca
                            marker.setIcon('http://maps.google.com/mapfiles/marker_green.png');
                            var map = this.get(0); //this.get(0) retorna la primera propietat vinculada-> gmap3
                            var infowindow = this.get(1); //this.get(1) retorna la segona propietat vinculada -> infowindow
                            infowindow.setContent(marker.data);     //dins la finestra mostrem el atribut data de la marca
                            infowindow.open(map, marker);
                        })
                        .fit();
            });
        </script>

    </body>
</html>