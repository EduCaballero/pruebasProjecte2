<?php
require_once 'bbdd.php';
session_start();
if (isset($_SESSION["id"])) {
    if ($_SESSION["tipo"] == "L") {
        $userData = mysqli_fetch_array(getUserDataById($_SESSION["id"]));
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ConcertPush - Local</title>
                <link rel="stylesheet" href="css/font-awesome.css">
                <link rel="stylesheet" href="css/local.css">
                <link rel="stylesheet" href="css/intranet.css">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
                <script src="js/src/jquery-3.1.1.min.js"></script>
                <script src="js/src/modal.js"></script>
                <script src="js/src/mobile.js"></script>
                <script src="js/src/local.js"></script>
            </head>
            <body>
                <header>
                    <?php require_once 'includes/header-intranet.php'; ?>
                </header>
                <div id="container">
                    <div id="profile">
                        <?php require_once 'includes/local-profile.php'; ?>
                    </div>
                    <div id="main">
                        <div id="create" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-calendar-plus-o"></span>Crear concierto</h2>
                                <form id='create-concert'>
                                    <div class="form-crt-row">
                                        <div class="form-crt-row-sub">
                                            <label>Fecha</label><input type="text" id="concert-date" name="concert-date" placeholder="dd-mm-aaaa">
                                        </div><div class="form-crt-row-sub">				
                                            <label>Hora</label><input type="text" id="concert-time" name="concert-time" placeholder="hh:mm"> 
                                        </div>
                                    </div><div class="form-crt-row">
                                        <div class="form-crt-row-sub">
                                            <label>Género</label><select name="genre">
                                                <option value="">Elige un género</option>
                                                <?php
                                                $generos = AllGeneros();
                                                while ($fila = mysqli_fetch_array($generos)) {
                                                    extract($fila);
                                                    echo "<option value='$id_genero'>$nombre</option>";
                                                }
                                                ?>
                                            </select>
                                        </div><div class="form-crt-row-sub">
                                            <label>Pago</label><input type="text" name="pay" placeholder="€"></div>
                                    </div>
                                    <input type="submit" value="Crear" name="create" class="btn btn-submit"/>
                                </form>
                            </div>
                        </div>
                        <?php
                        require_once 'includes/modal-update-pending.php';
                        require_once 'includes/modal-inscritos.php';
                        ?>
                        <div id="pending" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-calendar"></span>Conciertos pendientes de asignar</h2>
                                <table id="pending-conc" class="contentTable">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th width="45%">Género</th>
                                            <th>Pago</th>
                                            <th>Inscritos</th>
                                            <th colspan="3" width="25%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $concCreated = concCreatedLoc($_SESSION["id"]);
                                        while ($row = mysqli_fetch_array($concCreated)) {
                                            //<td style='display: none'>".$row["id_concierto"]."</td>
                                            echo "
                                            <tr>
                                                <input type='hidden' value='" . $row["id_concierto"] . "'>	
                                                <td>" . $row["dia"] . "</td>
                                                <td>" . $row["hora"] . "</td>
                                                <td>" . $row["genero"] . "</td>
                                                <td>" . $row["pago"] . "</td>
                                                <td>" . $row["inscritos"] . "</td>
                                                <td><span class='act-del'>Eliminar</span></td>
                                                <td><span class='act-upd-pending'>Modificar</span></td>
                                                <td><span class='act-ins'>Ver inscritos</span></td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="assigned" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-calendar-check-o"></span>Conciertos asignados</h2>
                                <table id="assigned-conc" class="contentTable">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th width="18%">Género</th>
                                            <th width="30%">Músico/Grupo</th>
                                            <th>Pago</th>
                                            <th>Votos</th>
                                            <th colspan="2" width="25%" >Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $concAssign = concAssignLoc($_SESSION["id"]);
                                        while ($row = mysqli_fetch_array($concAssign)) {
                                            echo "
                                            <tr>
                                                <input type='hidden' value='" . $row["concierto"] . "'>
                                                <input type='hidden' value='" . $row["idmusico"] . "'>
                                                <td>" . $row["dia"] . "</td>
                                                <td>" . $row["hora"] . "</td>
                                                <td>" . $row["genero"] . "</td>
                                                <td>" . $row["musico"] . "</td>
                                                <td>" . $row["pago"] . "</td>
                                                <td>" . $row["votos"] . "</td>
                                                <td><span class='act-del'>Eliminar</span></td>
                                                <td><span class='act-drop'>Dar de baja</span></td>
                                            </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <footer class="footer">
                            <div class="content-container">
                                <?php require_once 'includes/footer.php'; ?>
                            </div>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    } else {
        if ($_SESSION["tipo"] == "F") {
            header("Location: fan.php");
        } else if ($_SESSION["tipo"] == "M") {
            header("Location: musico.php");
        }
    }
} else {
    header("Location: index.php");
}
?>