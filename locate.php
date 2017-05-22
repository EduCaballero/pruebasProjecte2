<html>
    <head>
        <script src="js/src/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBADbTshi09zvXeMmaRaK9ehxqcNI9pA0&region=GB"></script>
        <script src="js/src/gmap3.min.js" type="text/javascript"></script>
        <!--<script src="slick/slick.min.js" type="text/javascript"></script>
        <script src="js/src/gmap.js" type="text/javascript"></script>
        <link href="slick/slick.css" rel="stylesheet" type="text/css"/>
        <link href="slick/slick-theme.css" rel="stylesheet" type="text/css"/>
        <link href="css/gmap.css" rel="stylesheet" type="text/css"/>-->
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
    </p>
    <?php
    //$addr = $_GET["addr"];
    //echo $addr;
    //$addr3 = "";
    //if ($addr == "tresPuntos") {
    //    $addr3 = "Madrid";
    //}
    ?>
    <div id="mapa2" style="width: 500px; height:400px;"></div>
    <script>
        $(document).ready(init);
        function init() {
        $('#mapa2')
                .gmap3({
                zoom: 4
                })
                .infowindow({content: "contentString"})
                .marker([
                {position: [48.8620722, 2.352047], data: contentString},
                {address: "<?php echo $direccion ?>", data: "<h3>Titulo</h3><div><?php echo $direccion ?></div>", icon: "http://maps.google.com/mapfiles/marker_grey.png"}
<?php if ($addr3 != "") { ?>
                    , {address:"Madrid", data:"Quiero unas porras con chocolate"}
<?php } ?>
                ])
                .on('click', function (marker) {  //Al clicar obrim una finestra sobre la marca i hi insertem el data de la marca
                marker.setIcon('http://maps.google.com/mapfiles/marker_green.png');
                var map = this.get(0); //this.get(0) retorna la primera propietat vinculada-> gmap3
                var infowindow = this.get(1); //this.get(1) retorna la segona propietat vinculada -> infowindow
                infowindow.setContent(marker.data); //dins la finestra mostrem el atribut data de la marca
                infowindow.open(map, marker);
                })
                .then(function (markers) {
                markers[1].setIcon('http://maps.google.com/mapfiles/marker_orange.png');
                })
                .fit();
        }


    </script>
</body>
</html>
