<?php

session_start();
require_once 'bbdd.php';

if ($_POST["signup"] == 1) {
    addMusicProp($_SESSION["id"], $_POST["concertId"]);
} else {
    delMusicProp($_SESSION["id"], $_POST["concertId"]);
}

$rows = "";
$pending = MusicoPendienteAsignar();
while ($row = mysqli_fetch_array($pending)) {
    $rows = $rows . "
    <tr>
        <input type='hidden' value='" . $row["id_concierto"] . "'>
        <td>" . $row["dia"] . "</td>
        <td>" . $row["hora"] . "</td>
        <td>" . $row["ciudad"] . "</td>
        <td>" . $row["local"] . "</td>
        <td>" . $row["genero"] . "</td>
        <td>" . $row["pago"] . "</td>
        <td>" . $row["inscritos"] . "</td>";
    if (musicSignedUp($_SESSION["id"], $row["id_concierto"])) {
        $rows = $rows . "
            <td><span class='disabled'>Inscribirse</span></td>
            <td><span class='enabled'>Baja</span></td>
	</tr>";
    } else {
        $rows = $rows . "
            <td><span class='signup enabled'>Inscribirse</span></td>
            <td><span class='disabled'>Baja</span></td>
	</tr>";
    }
}
echo json_encode($rows);
?>