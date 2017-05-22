<?php 

function insertConcierto($dia,$mes,$anyo,$hora,$min,$pago,$local,$genero) {
    $con = connect("proyecto");
    $insert = "insert into concierto(dia,hora,pago,local,genero,asignado) 
    values('$anyo-$mes-$dia','$hora:$min:00',$pago,$local,$genero,0)";
    if (mysqli_query($con, $insert)) {
       
    } else {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function agenda() {
	$con = connect("proyecto");
	$select = "select concierto.dia, local.nombre as local, musico.nombre as musico
	from concierto
	inner join usuario as local on concierto.local = local.id_usuario
	inner join propuesta on propuesta.concierto = concierto.id_concierto
	inner join usuario as musico on propuesta.musico = musico.id_usuario
	where propuesta.aceptado=1
	order by dia asc
	limit 7";
	$result = mysqli_query($con, $select);
	disconnect($con);
	return $result;
}

function ranking() {
	$con = connect("proyecto");
	$select = "select usuario.imagen, usuario.nombre as musico, genero.nombre as genero, count(voto_musico.fan) as votos 
	from usuario
	left join voto_musico on voto_musico.musico = usuario.id_usuario
	inner join musico on musico.id_musico = usuario.id_usuario
	inner join genero on musico.genero = genero.id_genero
	group by usuario.id_usuario
	order by votos desc 
	limit 5";
	$result = mysqli_query($con, $select);
	disconnect($con);
	return $result;
}

function concCreatedLoc() {
	$con = connect("proyecto");
	$select = "select concierto.dia, concierto.hora, genero.nombre as genero, concierto.pago, count(propuesta.musico) as inscritos
    from concierto 
    left join propuesta on propuesta.concierto = concierto.id_concierto
    join usuario on concierto.local = usuario.id_usuario
    join genero on concierto.genero = genero.id_genero
    where concierto.asignado = 0 and usuario.id_usuario = 6
    group by concierto.dia, concierto.hora, genero.nombre, concierto.pago
    order by concierto.dia asc limit 7";
	$result = mysqli_query($con, $select);
	disconnect($con);
	return $result;
}

function concAssignLoc() {
	$con = connect("proyecto");
	$select = "select concierto.dia, concierto.hora, genero.nombre as genero, usuario.nombre as musico, concierto.pago, count(*) as votos
	from concierto
	join genero on concierto.genero = genero.id_genero
	join propuesta on concierto.id_concierto = propuesta.concierto
	join usuario on propuesta.musico = usuario.id_usuario 
	join voto_concierto on voto_concierto.concierto = concierto.id_concierto
	where propuesta.aceptado = 1 and concierto.local=6 
	group by voto_concierto.concierto, concierto.dia, concierto.hora, genero.nombre, usuario.nombre, concierto.pago";
	$result = mysqli_query($con, $select);
	disconnect($con);
	return $result;
}

function selectEmail($email) {
    $con = connect("proyecto");
    $select = "select mail from usuario where mail = '$email'";
    $res = mysqli_query($con,$select);
    disconnect($con);
    return $res;
}

function checkEmail($reqEmail) {
    $con = connect("proyecto");
    $select = "select mail from usuario where mail = '$reqEmail'";
    $res = mysqli_query($con,$select);
    disconnect($con);
    return $res;
}

function AllGeneros() {
    $con = connect("proyecto");
    $select = "select * from genero";
    $res = mysqli_query($con,$select);
    disconnect($con);
    return $res;
}

function selectProvincias() {
    $con = connect("proyecto");
    $select = "select id, provincia from provincias";
    $res = mysqli_query($con,$select);
    disconnect($con);
    return $res;
}

function selectMunicipiosByProv($provincia) {
    $con = connect("proyecto");
    $select = "select id, municipio from municipios where provincia_id='$provincia'";
    $res = mysqli_query($con,$select);
    disconnect($con);
    return $res;
}

function altaUsuario($email,$pass,$user,$ciudad,$telefono,$web,$nombre) {
    $con = connect("proyecto");
// Tenemos la conexión con la BBDD :)
// Preparamos el insert
    $insert = "insert into usuario(nombre,mail,password,tipo,ciudad,telefono,imagen) values('$nombre','$email','$pass','$user','$ciudad','$telefono', 'img/default_profile.jpg')";
    // Insertamos en la bbdd
    if (mysqli_query($con, $insert)) {
        echo '
        <div id="done">
            <p><b>Gracias por registrarte.</b></p>
            <p><a href="signin.php">Entrar a Concertpush con tu cuenta.</a></p>
            <p><a href="index.php">Ir a la pagina principal.</a></p>
        </div>
        ';
    } else {
        // Si hay error lo mostramos por pantalla
        echo mysqli_error($con);
    }
    // Desconectamos
    disconnect($con);
}

function altaFan($sex,$apellidos,$day,$month,$year) {
    $con = connect("proyecto");
// Tenemos la conexión con la BBDD :)
    $idsel = mysqli_query($con,"select id_usuario from usuario order by id_usuario desc limit 1");
    $id = mysqli_fetch_array($idsel,MYSQLI_NUM);
// Preparamos el insert
    $insert = "insert into fan(id_fan,apellidos,sexo,fecha_nac) 
    values('$id[0]','$apellidos','$sex','$year-$month-$day')";
    // Insertamos en la bbdd
    if (mysqli_query($con, $insert)) {
        // Ha ido todo bien
    } else {
        // Si hay error lo mostramos por pantalla
        echo mysqli_error($con);
    }
    // Desconectamos
    disconnect($con);
}

function altaMusico($numMiembros,$generoMusico) {
    $con = connect("proyecto");
// Tenemos la conexión con la BBDD :)
    $idsel = mysqli_query($con,"select id_usuario from usuario order by id_usuario desc limit 1");
    $id = mysqli_fetch_array($idsel,MYSQLI_NUM);
// Preparamos el insert
    $insert = "insert into musico(id_musico,n_componentes,genero)
    values('$id[0]',$numMiembros,$generoMusico)";
    // Insertamos en la bbdd
    if (mysqli_query($con, $insert)) {
        // Ha ido todo bien
    } else {
        // Si hay error lo mostramos por pantalla
        echo mysqli_error($con);
    }
    // Desconectamos
    disconnect($con);
}

function altaLocal($dir,$aforo) {
    $con = connect("proyecto");
    $idsel = mysqli_query($con,"select id_usuario from usuario order by id_usuario desc limit 1");
    $id = mysqli_fetch_array($idsel,MYSQLI_NUM);
// Preparamos el insert
    $insert = "insert into local(id_local,aforo,direccion) 
    values('$id[0]',$aforo,'$dir')";
    // Insertamos en la bbdd
    if (!mysqli_query($con, $insert)) {
       // Si hay error lo mostramos por pantalla
        echo mysqli_error($con);
    }
    // Desconectamos
    disconnect($con);
}

//Musicos Tabla 1
function MusicoPendienteAsignar() {
    $con = connect("proyecto");
    $select = "select concierto.dia, concierto.hora, ciudad.nombre as ciudad, usuario.nombre as local, 
    genero.nombre as genero, concierto.pago, count(*) as inscritos
    from propuesta
    join concierto on propuesta.concierto=concierto.id_concierto
    join usuario on concierto.local=usuario.id_usuario
    join ciudad on usuario.ciudad=ciudad.id_ciudad
    join genero on concierto.genero=genero.id_genero
    where concierto.asignado = 0
    group by concierto.dia, concierto.hora, ciudad.nombre, propuesta.concierto, usuario.nombre, genero.nombre, concierto.pago
    order by concierto.dia asc limit 7
    ";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}

//Musicos Tabla 2
function MusicoAsignado() {
    $con = connect("proyecto");
    $select = "select concierto.dia, concierto.hora, ciudad.nombre as ciudad, usuario.nombre as loc, local.direccion, concierto.pago
    from concierto
    join usuario on usuario.id_usuario = concierto.local
    join ciudad on usuario.ciudad=ciudad.id_ciudad
    join local on local.id_local = usuario.id_usuario
    join propuesta on propuesta.concierto=concierto.id_concierto
    where propuesta.aceptado = 1 and propuesta.musico = 3 limit 7
    ";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}

//Fans Tabla 1
function FanVotaConciertos() {
    $con = connect("proyecto");
    $select = "select concierto.dia, concierto.hora, municipios.municipio, local.nombre as local, musico.nombre as musico, count(voto_concierto.fan) as votos, concierto.id_concierto
    from concierto
    inner join propuesta on propuesta.concierto=concierto.id_concierto
    inner join usuario as local on concierto.local=local.id_usuario
    inner join usuario as musico on propuesta.musico = musico.id_usuario
    inner join municipios on local.ciudad=municipios.id
    left join voto_concierto on voto_concierto.concierto=concierto.id_concierto
    where propuesta.aceptado = 1
    group by concierto.id_concierto, concierto.dia, concierto.hora, municipios.municipio, local.nombre, musico.nombre
    ORDER BY dia ASC LIMIT 5";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}


//Fans Tabla 2
function FanVotaMusicos() {
    $con = connect("proyecto");
    $select = "select usuario.imagen, usuario.nombre, genero.nombre as genero, count(voto_musico.fan) as votos, usuario.id_usuario as musico
    from musico
    inner join genero on genero.id_genero=musico.genero
    inner join usuario on usuario.id_usuario=musico.id_musico
    left join voto_musico on voto_musico.musico=usuario.id_usuario
    group by usuario.id_usuario
    order by votos desc limit 7";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}

function fanVoteConcert($concertId,$fanId) {
 $con = connect("proyecto");
 $select = "select voto_concierto.fan
 from voto_concierto
 where voto_concierto.concierto = '$concertId' and voto_concierto.fan = '$fanId'";
 $res = mysqli_query($con, $select);
 disconnect($con);
 return $res;            
}

function fanVoteMusic($musicId,$fanId) {
	$con = connect("proyecto");
 $select = "select voto_musico.fan
 from voto_musico
 where voto_musico.musico = '$musicId' and voto_musico.fan = '$fanId'";
 $res = mysqli_query($con, $select);
 disconnect($con);
 return $res;            
}

function addConVote($fanId,$conId) {
	$con = connect("proyecto");
    $insert = "insert into voto_concierto values('$fanId','$conId')";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function delConVote($fanId,$conId) {
	$con = connect("proyecto");
    $delete = "delete from voto_concierto where fan='$fanId' and concierto='$conId'";
    if (!mysqli_query($con, $delete)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function addMusicVote($fanId,$musicId) {
	$con = connect("proyecto");
    $insert = "insert into voto_musico values('$fanId','$musicId')";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function delMusicVote($fanId,$musicId) {
	$con = connect("proyecto");
    $delete = "delete from voto_musico where fan='$fanId' and musico='$musicId'";
    if (!mysqli_query($con, $delete)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function connect($database) {
	$con = mysqli_connect("localhost", "root", "", $database)
	or die("No se ha podido conectar a la BBDD");
	mysqli_set_charset($con,"utf8");        
	return $con;
}

function disconnect($con) {
	mysqli_close($con);
}
?>