<?php

require_once 'bbdd.php';

$id = $_POST["id"];
$municipios = selectMunicipiosByProv($id);
$data = $municipios->fetch_all(MYSQLI_ASSOC);
echo (json_encode($data));
?>