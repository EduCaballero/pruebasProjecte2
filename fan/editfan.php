<?php
require_once '../bbdd.php';
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
                <title>ConcertPush - Editar perfil</title>
                <link rel="stylesheet" href="../css/font-awesome.css">
                <link rel="stylesheet" href="../css/editprofile.css">
                <link rel="stylesheet" href="../css/intranet.css">
                <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
                <script src="../js/src/menu.js"></script>
            </head>
            <body>
                <header>
                    <?php require_once '../includes/header-intranet.php'; ?>
                </header>
                <div id="container">
                    <div id="profile">
                        <?php require_once '../includes/fan-profile.php'; ?>
                    </div>
                    <div id="main">
                        <div id="form-container" class="content">
                            <div class="content-container">
                                <h2><span class="fa fa-pencil"></span>Información personal</h2>
                                <form class="form-profile" action="" method="POST">
                                    <div class="form-row">
                                        <label>Nombre</label><div class="input-wrap">
                                            <input type="text" name="name"/></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Apellidos</label><div class="input-wrap">
                                            <input type="text" name="surname"></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Ciudad</label><div class="input-wrap">
                                            <input type="text" name="city"></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Teléfono</label><div class="input-wrap">
                                            <input type="text" name="tlf" maxlength="9" pattern="\d*"></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Nuevo email</label><div class="input-wrap">
                                            <input type="email" name="newEmail"/></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Confirma email</label><div class="input-wrap">
                                            <input type="email" name="emailConfirm"/></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Contraseña actual</label><div class="input-wrap">
                                            <input type="password" name="currentPass"></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Nueva contraseña</label><div class="input-wrap">
                                            <input type="password" name="newPass"></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Confirma contraseña</label><div class="input-wrap">
                                            <input type="password" name="ConfirmNewPass"></div>
                                    </div>
                                    <div class="form-row">
                                        <label>Imagen de perfil </label><div class="input-wrap">
                                            <input type="file" name="imgprofile"></div>
                                    </div>
                                    <div class="form-row">
                                        <label></label><div class="input-wrap">
                                            <input type="submit" value="Modificar" class="btn btn-submit"/><input type="reset" value="Limpiar" class="btn btn-reset"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <footer class="footer">
                            <?php require_once '../includes/footer.php'; ?>
                        </footer>
                    </div>
                </div>
            </body>
        </html>
        <?php
    } else {
        if ($_SESSION["tipo"] == "L") {
            header("Location: ../local/editlocal.php");
        } else if ($_SESSION["tipo"] == "M") {
            header("Location: ../musico/editmusico.php");
        }
    }
} else {
    header("Location: index.php");
}
?>