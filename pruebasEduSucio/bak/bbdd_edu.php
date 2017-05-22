<?php

//MOD edu pendiente de aprobar-------------------------------------------------------
function altaUsuario($email, $pass, $user, $ciudad, $telefono, $web, $nombre) {
    $con = connect("proyecto");
    $passCif = password_hash($pass, PASSWORD_DEFAULT);
    $insert = "insert into usuario values('$nombre','$email','$passCif','$user','$ciudad','$telefono', 'img/default_profile.jpg')";
    if (mysqli_query($con, $insert)) {
        echo '
        <div id="done">
            <p><b>Gracias por registrarte.</b></p>
            <p><a href="signin.php">Entrar a Concertpush con tu cuenta.</a></p>
            <p><a href="index.php">Ir a la pagina principal.</a></p>
        </div>';
    } else {
        echo mysqli_error($con);
    }
    disconnect($con);
}

//----------------------------------------------------------

function updateUserPass($id, $pass) {
    $con = connect("proyecto");
    $passCif = password_hash($pass, PASSWORD_DEFAULT);
    $update = "update usuario set password = '$passCif' where id_usuario='$id'";
    if (!mysqli_query($con, $update)) { //por qué el '!' ?? Sería mejor mostrar también algo si la contraseña, no? aunque sea un "contraseña actualizada correctamente.
        echo mysqli_error($con);
    }
    disconnect($con);
}

