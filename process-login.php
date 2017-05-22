<?php
require_once 'bbdd.php';
if (isset($_POST["validation"])) {
    $errors = array();
    if (empty($_POST["email"])) {
        $errors["email"] = 'No has introducido un email';
    } else if (!userExists($_POST["email"])) {
        $errors["email"] = 'El correo introducido no está registrado';
    }

    if (empty($_POST["password"])) {
        $errors["password"] = 'No has introducido una contraseña';
    } else if (!validateUser($_POST["email"], $_POST["password"])) {
        $errors["password"] = 'La contraseña es incorrecta';
    }

    if (count($errors) > 0) {
        echo json_encode($errors);
        exit;
    } else {
        echo json_encode(true);
        exit;
    }
} else {
    if (validateUser($_POST["email"], $_POST["password"])) {
        session_start();
        $_SESSION["user"] = $_POST["email"];
        $_SESSION["tipo"] = getTypeByUser($_POST["email"]);
        $_SESSION["id"] = getIdByUser($_POST["email"]);
        if ($_SESSION["tipo"] == "L") {
            header("Location: local.php");
        } else if ($_SESSION["tipo"] == "M") {
            header("Location: musico.php");
        } else {
            header("Location: fan.php");
        }
        // No deberia pasar nunca en teoria...	
    } else {
        header("Location: index.php");
    }
}
?>