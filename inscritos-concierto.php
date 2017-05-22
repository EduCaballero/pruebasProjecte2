<?php

require_once 'bbdd.php';
$inscritos = inscritosConcert($_POST["concert"]);
$tableRow = "";
while ($row = mysqli_fetch_array($inscritos)) {
    $tableRow = $tableRow . "
    <tr>
        <input type='hidden' value='" . $_POST["concert"] . "'>
        <input type='hidden' value='" . $row["musico"] . "'>
        <td><img src='img/" . $row["imagen"] . "'></td>
        <td>" . $row["nombre"] . "</td>
        <td>" . $row["genero"] . "</td>
        <td>" . $row["votos"] . "</td>
        <td><span class='act-accept'>Aceptar</span></td>
    </tr>";
}
if ($tableRow == "") {
    echo json_encode("<h3>No hay ningun músico inscrito en este concierto</h3>");
} else {
    $table = "
    <table id='inscritos-table' class='contentTable'>
        <thead>
            <tr>
                <th colspan='2'>Músico / Grupo</th>
                <th width='250px'>Género</th>
                <th>Votos</th>
                <th width='130px'>Acción</th>
            </tr>
        </thead>
        <tbody>" . $tableRow . "</tbody>
    </table>";
    echo json_encode($table);
}
?>