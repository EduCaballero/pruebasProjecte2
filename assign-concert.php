<?php 
session_start();
require_once 'bbdd.php';
assignConcert($_POST["concert"], $_POST["music"], $_POST["assign"]);

$pendingRows="";
$concCreated = concCreatedLoc($_SESSION["id"]);
while ($row = mysqli_fetch_array($concCreated)) {
	$pendingRows = $pendingRows."
	<tr>
		<input type='hidden' value='".$row["id_concierto"]."'>	
		<td>".$row["dia"]."</td>
		<td>".$row["hora"]."</td>
		<td>".$row["genero"]."</td>
		<td>".$row["pago"]."</td>
		<td>".$row["inscritos"]."</td>
		<td><span class='act-del'>Eliminar</span></td>
		<td><span class='act-upd-pending'>Modificar</span></td>
		<td><span class='act-ins'>Ver inscritos</span></td>
	</tr>";
}
$assignedRows="";
$concAssign = concAssignLoc($_SESSION["id"]);
while ($row = mysqli_fetch_array($concAssign)) {
	$assignedRows = $assignedRows."
	<tr>
		<input type='hidden' value='".$row["concierto"]."'>
		<input type='hidden' value='".$row["idmusico"]."'>
		<td>".$row["dia"]."</td>
		<td>".$row["hora"]."</td>
		<td>".$row["genero"]."</td>
		<td>".$row["musico"]."</td>
		<td>".$row["pago"]."</td>
		<td>".$row["votos"]."</td>
		<td><span class='act-del'>Eliminar</span></td>
		<td><span class='act-drop'>Dar de baja</span></td>
	</tr>";
}

//$data = array('pending' => $pendingRows, 'assigned' => $assignedRows);
if (empty($_POST["concert"])) {
	$data = array('concert_vasio' => 'sii');
} else $data = array('pending' => $pendingRows, 'assigned' => $assignedRows);
echo json_encode($data);
?>