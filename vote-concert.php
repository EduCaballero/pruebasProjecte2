<?php

session_start();
require_once 'bbdd.php';

// $_POST["vote"] == true ? addConVote($_SESSION["id"],$_POST["concertId"]) : delConVote($_SESSION["id"],$_POST["concertId"]);


if ($_POST["vote"] == 1) {
    addConVote($_SESSION["id"], $_POST["concertId"]);
} else {
    delConVote($_SESSION["id"], $_POST["concertId"]);
}

$rows = "";
$concerts = FanVotaConciertos();
while ($row = mysqli_fetch_array($concerts)) {
    $rows = $rows . "
    <tr>
        <input type='hidden' value='" . $row["id_concierto"] . "'>
        <td>" . $row["dia"] . "</td>
        <td>" . $row["hora"] . "</td>
        <td>" . $row["municipio"] . "</td>
        <td>" . $row["local"] . "</td>
        <td>" . $row["musico"] . "</td>
        <td>" . $row["votos"] . "</td>";
    if (fanVoteConcert($row["id_concierto"], $_SESSION["id"])) {
        $rows = $rows . "
            <td><i class='fa fa-lg fa-thumbs-o-up disabled'/></td>
            <td><button class='fa fa-lg fa-thumbs-o-down enabled' title='-1'></td>
	</tr>";
    } else {
        $rows = $rows . "
            <td><button class='fa fa-lg fa-thumbs-o-up enabled' title='+1'></td>
            <td><i class='fa fa-lg fa-thumbs-o-down disabled'/></td>
	</tr>";
    }
}
echo json_encode($rows);
?>