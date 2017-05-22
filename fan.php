<?php
require_once 'bbdd.php';
session_start();
if (isset($_SESSION["id"])) {
    if ($_SESSION["tipo"] == "F") {
        $userData = mysqli_fetch_array(getUserDataById($_SESSION["id"]));
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ConcertPush - Fan</title>
                <link rel="stylesheet" href="css/font-awesome.css">
                <link rel="stylesheet" href="css/intranet.css">
                <link rel="stylesheet" href="css/fan.css">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
                <script src="js/src/jquery-3.1.1.min.js"></script>	
                <script src="js/src/mobile.js"></script>
                <script src="js/src/fan.js"></script>
            </head>
            <body>
                <header>
                    <?php require_once 'includes/header-intranet.php'; ?>
                </header>
                <div id="container">
                    <div id="profile">
                        <?php require_once 'includes/fan-profile.php'; ?>
                    </div>
                    <div id="main">
                        <div id="vote-concert" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-comments-o"></span>Vota conciertos</h2>
                                <table class="contentTable">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th width="20%">Ciudad</th>
                                            <th width="26%">Local</th>
                                            <th width="26%">Músico</th>
                                            <th>Votos</th>
                                            <th colspan="2">Vota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //Llamamos a la funcion de la tabla 1 de fans
                                        $concerts = FanVotaConciertos();
                                        //Extraccion de datos
                                        while ($row = mysqli_fetch_array($concerts)) {
                                            echo "
                                            <tr>
                                                <input type='hidden' value='" . $row["id_concierto"] . "'>
                                                <td>" . $row["dia"] . "</td>
                                                <td>" . $row["hora"] . "</td>
                                                <td>" . $row["municipio"] . "</td>
                                                <td>" . $row["local"] . "</td>
                                                <td>" . $row["musico"] . "</td>
                                                <td>" . $row["votos"] . "</td>";
                                            // Comprobamos si el fan ha votado a este concierto
                                            // Si ha votado puede retirar el voto, si no ha votado puede votar.
                                            if (fanVoteConcert($row["id_concierto"], $_SESSION["id"])) {
                                                echo "
                                                    <td><i class='fa fa-lg fa-thumbs-o-up disabled'/></td>
                                                    <td><button class='fa fa-lg fa-thumbs-o-down enabled' title='-1'></td>
                                                </tr>";
                                            } else {
                                                echo "
                                                    <td><button class='fa fa-lg fa-thumbs-o-up enabled' title='+1'></td>
                                                    <td><i class='fa fa-lg fa-thumbs-o-down disabled'/></td>
						</tr>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="vote-music" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-comments-o"></span>Vota músicos / grupos</h2>
                                <table class="contentTable">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Músico / Grupo</th>
                                            <th width="25%">Género</th>
                                            <th>Votos</th>
                                            <th colspan="2">Vota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //Llamamos a la funcion de la tabla 2 de fans
                                        $musics = FanVotaMusicos();
                                        //Extraccion de datos
                                        while ($row = mysqli_fetch_array($musics)) {
                                            echo "
                                            <tr>
                                                <input type='hidden' value='" . $row["musico"] . "'>
                                                <td><img src='img/" . $row["imagen"] . "' alt=''></td>
                                                <td width='60%'>" . $row["nombre"] . "</td>
                                                <td>" . $row["genero"] . "</td>
                                                <td>" . $row["votos"] . "</td>";
                                            // Comprobamos si el fan ha votado a este musico
                                            // Si ha votado puede retirar el voto, si no ha votado puede votar.		
                                            if (fanVoteMusic($row["musico"], $_SESSION["id"])) {
                                                echo "
                                                    <td><i class='fa fa-lg fa-thumbs-o-up disabled'/></td>
                                                    <td><button class='fa fa-lg fa-thumbs-o-down enabled' title='-1'></td>
						</tr>";
                                            } else {
                                                echo "
                                                    <td><button class='fa fa-lg fa-thumbs-o-up enabled' title='+1'></td>
                                                    <td><i class='fa fa-lg fa-thumbs-o-down disabled'/></td>
						</tr>";
                                            }
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
        if ($_SESSION["tipo"] == "L") {
            header("Location: local.php");
        } else if ($_SESSION["tipo"] == "M") {
            header("Location: musico.php");
        }
    }
} else {
    header("Location: index.php");
}
?>