<?php

$uploaddir = '../img/';
$uploadfile = $uploaddir . basename($_FILES["profileImg"]["name"]);
$fileType = pathinfo($uploadfile, PATHINFO_EXTENSION);
$allowedFileTypes = array("jpg", "png", "jpeg", "gif");
$uploadOk = false;
// Miramos si se ha seleccionado un archivo y si es una imagen
if ($_FILES["profileImg"]["size"] > 0 && $_FILES['profileImg']['error'] == UPLOAD_ERR_OK) {
    $check = getimagesize($_FILES["profileImg"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = true;
    } else {
        $error_msg = "Archivo invalido.";
        $uploadOk = false;
    }

    if ($uploadOk && $_FILES["profileImg"]["size"] > 500000) {
        $error_msg = "La imagen no puede pesar más de 500kb.";
        $uploadOk = false;
    }
    // Si el archivo es una imagen pero no es JPG, JPEG, PNG o GIF
    if ($uploadOk && !in_array($fileType, $allowedFileTypes)) {
        $error_msg = "Solo se permiten imagenes en formato JPG, JPEG, PNG y GIF.";
        $uploadOk = false;
    }

    if ($uploadOk) {
        // Concatena el directorio donde va a subirse, nombre de la imagen sin extension, 
        // hash sha1 del tiempo en microsegundos y un random entre 10000 y 90000, 
        // finalmente la extension de la imagen.
        // Asi evitamos que hayan imagenes con nombres duplicados en el server.
        $filename = basename($_FILES["profileImg"]["name"], "." . $fileType) . sha1(microtime(true) . mt_rand(10000, 90000)) . "." . $fileType;
        $uploadfile = $uploaddir . $filename;
        if (move_uploaded_file($_FILES["profileImg"]["tmp_name"], $uploadfile)) {
            // Si se ha podido subir la imagen, la insertamos en la bbdd
            updateProfileImage($filename, $_SESSION["id"]);
        } else {
            $error_msg = "Se ha producido un error al subir la imagen.";
        }
    }
}
?>