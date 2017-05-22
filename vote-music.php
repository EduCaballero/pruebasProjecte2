<?php

session_start();
require_once 'bbdd.php';

if ($_POST["vote"] == 1) {
    addMusicVote($_SESSION["id"], $_POST["musicId"]);
} else {
    delMusicVote($_SESSION["id"], $_POST["musicId"]);
}

$rows = "";
$musics = FanVotaMusicos();
while ($row = mysqli_fetch_array($musics)) {
    $rows = $rows . "
        <tr>
            <input type='hidden' value='" . $row["musico"] . "'>
            <td><img src='img/" . $row["imagen"] . "' alt=''></td>
            <td width='60%'>" . $row["nombre"] . "</td>
            <td>" . $row["genero"] . "</td>
            <td>" . $row["votos"] . "</td>";
    if (fanVoteMusic($row["musico"], $_SESSION["id"])) {
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