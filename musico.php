<?php
require_once 'bbdd.php';
session_start();
if (isset($_SESSION["id"])) {
    if ($_SESSION["tipo"] == "M") {
        $userData = mysqli_fetch_array(getUserDataById($_SESSION["id"]));
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ConcertPush - Músico</title>
                <link rel="stylesheet" href="css/font-awesome.css">
                <link rel="stylesheet" href="css/musico.css">
                <link rel="stylesheet" href="css/intranet.css">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
                <script src="js/src/jquery-3.1.1.min.js"></script>
                <script src="js/src/mobile.js"></script>
                <script src="js/src/musico.js"></script>
                <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfITkskFnkQFXkgSbMT-AoPXCx9_yHoXw&region=GB"></script>
            </head>
            <body>
                <header>
                    <?php require_once 'includes/header-intranet.php'; ?>
                </header>
                <div id="container">
                    <div id="profile">
                        <?php require_once 'includes/music-profile.php'; ?>
                    </div>
                    <div id="main">
                        <div id="pending" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-calendar"></span>Conciertos pendientes de asignar</h2>
                                <table id='pending-table' class="contentTable">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th width="18%">Ciudad</th>
                                            <th width="23%">Local</th>
                                            <th width="18%">Género</th>
                                            <th>Pago</th>
                                            <th>Inscritos</th>
                                            <th colspan="2">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $pending = MusicoPendienteAsignar();
                                        while ($row = mysqli_fetch_array($pending)) {
                                            echo "
                                            <tr>
                                                <input type='hidden' value='" . $row["id_concierto"] . "'>";
                                            //idLocal($row["id_concierto"]);
                                            echo "
                                                <td>" . $row["dia"] . "</td>
                                                <td>" . $row["hora"] . "</td>
                                                <td>" . $row["ciudad"] . '</td>
                                                <td><a href="locate.php/?paso=' . $row["id_concierto"] . '&paso2=' . $row["ciudad"] . '">' . $row["local"] . "</a></td>
                                                <td>" . $row["genero"] . "</td>
                                                <td>" . $row["pago"] . "</td>
                                                <td>" . $row["inscritos"] . "</td>";
                                            if (musicSignedUp($_SESSION["id"], $row["id_concierto"])) {
                                                echo "
                                                    <td><span class='disabled'>Inscribirse</span></td>
                                                    <td><span class='enabled'>Baja</span></td>
                                                </tr>";
                                            } else {
                                                echo "
                                                    <td><span class='signup enabled'>Inscribirse</span></td>
                                                    <td><span class='disabled'>Baja</span></td>
                                                </tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="assigned" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-calendar-check-o"></span>Conciertos asignados</h2>
                                <table id='assigned-table' class="contentTable">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th width="18%">Ciudad</th>
                                            <th width="23%">Local</th>
                                            <th width="36%">Dirección</th>
                                            <th width="10%">Pago</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        //Llamamos a la funcion de la tabla 2 de musicos
                                        $assigned = MusicoAsignado($_SESSION["id"]);
                                        //Extraccion de datos
                                        while ($row = mysqli_fetch_array($assigned)) {
                                            echo "
                                            <tr>
                                                <td>" . $row["dia"] . "</td>
                                                <td>" . $row["hora"] . "</td>
                                                <td>" . $row["ciudad"] . "</td>
                                                <td>" . $row["loc"] . "</td>
                                                <td>" . $row["direccion"] . "</td>
                                                <td>" . $row["pago"] . "</td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <footer class="footer">
                            <?php require_once 'includes/footer.php'; ?>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    } else {
        if ($_SESSION["tipo"] == "F") {
            header("Location: fan.php");
        } else if ($_SESSION["tipo"] == "L") {
            header("Location: local.php");
        }
    }
} else {
    header("Location: index.php");
}
?>