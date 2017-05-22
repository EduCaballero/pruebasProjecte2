<?php

require_once 'bbdd.php';
if (checkPass($_POST["currentPass"], $_POST["id"])) {
    echo json_encode(true);
}
else {
    echo json_encode(false);
}
?>