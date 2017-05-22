<?php

require_once 'bbdd.php';
if (userExists($_POST["email"])) {
    echo json_encode(false);
}
else {
    echo json_encode(true);
}
?>