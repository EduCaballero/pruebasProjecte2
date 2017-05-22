<?php
require_once '../bbdd.php';
session_start();
if (isset($_SESSION["id"])) {
	if ($_SESSION["tipo"]=="M") {
		$userData = mysqli_fetch_array(getUserDataById($_SESSION["id"]));
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ConcertPush - Editar perfil</title>
	<link rel="stylesheet" href="../css/font-awesome.css">
	<link rel="stylesheet" href="../css/editprofile.css">
	<link rel="stylesheet" href="../css/intranet.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
	<script src="../js/src/menu.js"></script>
</head>
<body>
	<header>
		<?php require_once '../includes/header-intranet.php'; ?>
	</header>
	<div id="container">
		<div id="profile">
			<?php require_once '../includes/music-profile.php'; ?>
		</div>
		<div id="main">
			<div id="form-container" class="content">
				<div class="content-container">
					<h2><span class="fa fa-pencil"></span>Información personal</h2>
					<form class="form-profile" action="" method="POST">
						<div class="form-row">
							<label>Nombre artístico</label><div class="input-wrap">
							<input type="text" name="nameArtist"/></div>
						</div>
						<div class="form-row">
							<label>Nº de miembros</label><div class="input-wrap">
							<input type="text" name="members" pattern="\d*"></div>
						</div>
						<div class="form-row">
							<label>Género</label><div class="input-wrap">
							<select name="genre">
								<option value="">Género</option>
								<option value="Pop">Pop</option>
								<option value="Rock">Rock</option>
								<option value="Disco">Disco</option>
								<option value="Clasica">Clásica</option>
								<option value="Heavy Metal">Heavy Metal</option>
								<option value="Jazz">Jazz</option>
								<option value="Blues">Blues</option>
								<option value="Country">Country</option>
								<option value="Electronica">Electronica</option>
								<option value="Hip-hop">Hip-hop</option>
								<option value="Dance">Dance</option>
								<option value="House">House</option>
								<option value="Trance">Trance</option>
								<option value="Folk">Folk</option>
								<option value="Punk">Punk</option>
								<option value="Raggae">Raggae</option>
								<option value="Alternative">Alternative</option>
								<option value="Proressive">Progressive</option>
								<option value="R&B and soul">Soul</option>
							</select></div>
						</div>
						<div class="form-row">
							<label>Ciudad</label><div class="input-wrap">
							<input type="text" name="city"></div>
						</div>
						<div class="form-row">
							<label>Teléfono</label><div class="input-wrap">
							<input type="text" name="tlf" maxlength="9" pattern="\d*"></div>
						</div>
						<div class="form-row">
							<label>Página web</label><div class="input-wrap">
							<input type="url" name="web"></div>
						</div>

						<div class="form-row">
							<label>Nuevo email</label><div class="input-wrap">
							<input type="email" name="newEmail"/></div>
						</div>
						<div class="form-row">
							<label>Confirma email</label><div class="input-wrap">
							<input type="email" name="emailConfirm"/></div>
						</div>
						<div class="form-row">
							<label>Contraseña actual</label><div class="input-wrap">
							<input type="password" name="currentPass"></div>
						</div>
						<div class="form-row">
							<label>Nueva contraseña</label><div class="input-wrap">
							<input type="password" name="newPass"></div>
						</div>
						<div class="form-row">
							<label>Confirma contraseña</label><div class="input-wrap">
							<input type="password" name="ConfirmNewPass"></div>
						</div>
						<div class="form-row">
							<label>Imagen de perfil </label><div class="input-wrap">
							<input type="file" name="imgprofile"></div>
						</div>
						<div class="form-row">
							<label></label><div class="input-wrap">
							<input type="submit" value="Modificar" class="btn btn-submit"/><input type="reset" value="Limpiar" class="btn btn-reset"></div>
						</div>
					</form>
				</div>
			</div>
			<footer class="footer">
				<?php require_once '../includes/footer.php'; ?>
			</footer>
		</div>
	</div>
</body>
</html>
<?php
	} else {
		if ($_SESSION["tipo"]=="L") header("Location: ../local/editlocal.php");
		else if($_SESSION["tipo"]=="F") header("Location: ../fan/editfan.php");
	}	 
} else header("Location: index.php");
?>