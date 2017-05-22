<?php

///////////////
//   INDEX   //
///////////////


function agenda() {
    $con = connect("proyecto");
    $select = "select date_format(concierto.dia, '%d-%m-%Y') as dia, local.nombre as local, musico.nombre as musico
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

////////////////////
//    BUSCADOR    //
////////////////////

function getQueryMusic($input) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario where nombre like '%$input%' and tipo='M'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function getMusicSearch($id) {
    $con = connect("proyecto");
    $query = "select usuario.imagen, usuario.nombre , genero.nombre genero
    from usuario
    join musico on musico.id_musico = usuario.id_usuario
    join genero on musico.genero = genero.id_genero
    where usuario.id_usuario = '$id'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function getFilteredMusic($search, $type, $genre) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario 
    join musico on musico.id_musico = usuario.id_usuario
    join genero on musico.genero = genero.id_genero
    where usuario.nombre like '%$search%' $type $genre";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function getQueryLocal($input) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario where nombre like '%$input%' and tipo='L'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function getLocalSearch($id) {
    $con = connect("proyecto");
    $query = "select usuario.imagen, usuario.nombre , municipios.municipio, local.direccion, usuario.mail, usuario.web, usuario.telefono
    from usuario
    join local on local.id_local = usuario.id_usuario
    join municipios on usuario.ciudad = municipios.id
    where usuario.id_usuario = '$id'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function getFilteredLocal($search, $type, $prov) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario
    join local on local.id_local = usuario.id_usuario 
    join municipios on usuario.ciudad = municipios.id
    where usuario.nombre like '%$search%' $type $prov";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function getFirstGen() {
    $con = connect("proyecto");
    $select = "select id_genero, nombre from genero order by nombre asc limit 5";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

function getRestGen() {
    $con = connect("proyecto");
    // Limit 5 , 2000 (el 2000 por si se van añadiendo mas generos, no tener que ir incrementando el limit)
    $select = "select id_genero, nombre from genero order by nombre asc limit 5, 2000";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

function getFirstProv() {
    $con = connect("proyecto");
    $select = "select id, provincia from provincias order by id asc limit 5";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

function getRestProv() {
    $con = connect("proyecto");
    $select = "select id, provincia from provincias order by id asc limit 5, 52";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

/////////////////
//    LOGIN    //
/////////////////

function userExists($email) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario where mail='$email'";
    $res = mysqli_query($con, $query);
    $rows = mysqli_num_rows($res);
    disconnect($con);
    if ($rows > 0)
        return true;
    else
        return false;
}

function validateUser($email, $pass) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario where mail='$email' and password='$pass'";
    $res = mysqli_query($con, $query);
    $rows = mysqli_num_rows($res);
    disconnect($con);
    if ($rows > 0)
        return true;
    else
        return false;
}

//////////////////
//    SIGNUP    //
//////////////////


function altaUsuario($email, $pass, $user, $ciudad, $telefono, $web, $nombre) {
    $con = connect("proyecto");
    $insert = "insert into usuario(nombre,mail,password,tipo,ciudad,telefono,imagen) values('$nombre','$email','$pass','$user','$ciudad','$telefono', 'img/default_profile.jpg')";
    if (mysqli_query($con, $insert)) {
        echo '
        <div id="done">
            <p><b>Gracias por registrarte.</b></p>
            <p><a href="signin.php">Entrar a Concertpush con tu cuenta.</a></p>
            <p><a href="index.php">Ir a la pagina principal.</a></p>
        </div>';
    } else {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function altaFan($sex, $apellidos, $day, $month, $year) {
    $con = connect("proyecto");
    $idsel = mysqli_query($con, "select id_usuario from usuario order by id_usuario desc limit 1");
    $id = mysqli_fetch_array($idsel, MYSQLI_NUM);
    $insert = "insert into fan(id_fan,apellidos,sexo,fecha_nac) 
    values('$id[0]','$apellidos','$sex','$year-$month-$day')";
    if (!mysqli_query($con, $insert)) {
        // Si hay error lo mostramos por pantalla
        echo mysqli_error($con);
    }
    disconnect($con);
}

function altaMusico($numMiembros, $generoMusico) {
    $con = connect("proyecto");
    $idsel = mysqli_query($con, "select id_usuario from usuario order by id_usuario desc limit 1");
    $id = mysqli_fetch_array($idsel, MYSQLI_NUM);
    $insert = "insert into musico(id_musico,n_componentes,genero)
    values('$id[0]',$numMiembros,$generoMusico)";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function altaLocal($dir, $aforo) {
    $con = connect("proyecto");
    $idsel = mysqli_query($con, "select id_usuario from usuario order by id_usuario desc limit 1");
    $id = mysqli_fetch_array($idsel, MYSQLI_NUM);
    $insert = "insert into local(id_local,aforo,direccion) 
    values('$id[0]',$aforo,'$dir')";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

///////////////////////////////////
//   RECOGIDA DE DATOS DEL USER  //
///////////////////////////////////



function getIdByUser($user) {
    $con = connect("proyecto");
    $query = "select id_usuario from usuario where mail='$user'";
    // Ejecutamos la consulta
    $resultado = mysqli_query($con, $query);
    // Extraemos el resultado
    $fila = mysqli_fetch_array($resultado);
    extract($fila);
    disconnect($con);
    return $id_usuario;
}

function getTypeByUser($user) {
    $con = connect("proyecto");
    $query = "select tipo from usuario where mail='$user'";
    // Ejecutamos la consulta
    $resultado = mysqli_query($con, $query);
    // Extraemos el resultado
    $fila = mysqli_fetch_array($resultado);
    extract($fila);
    disconnect($con);
    return $tipo;
}

function getUserDataById($id) {
    $con = connect("proyecto");
    $query = "select id_usuario, nombre, mail, tipo, ciudad, telefono, web, imagen 
    from usuario where id_usuario='$id'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

/////////////////////////////
//   FORMULARIOS COMUNES   //
/////////////////////////////


function AllGeneros() {
    $con = connect("proyecto");
    $select = "select * from genero";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

function selectProvincias() {
    $con = connect("proyecto");
    $select = "select id, provincia from provincias";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

function selectMunicipiosByProv($provincia) {
    $con = connect("proyecto");
    $select = "select id, municipio from municipios where provincia_id='$provincia'";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

///////////////
//   LOCAL   //
///////////////

function updateConcert($day, $month, $year, $hour, $min, $pay, $genre, $id) {
    $con = connect("proyecto");
    $update = "update concierto set dia='$year-$month-$day', hora ='$hour:$min:00', pago = '$pay', genero = '$genre'
    where id_concierto = '$id'";
    mysqli_query($con, $update);
    disconnect($con);
}

function deleteConcert($id) {
    $con = connect("proyecto");
    $delete = "delete from concierto where id_concierto='$id'";
    mysqli_query($con, $delete);
    disconnect($con);
}

function inscritosConcert($id) {
    $con = connect("proyecto");
    $query = "select usuario.imagen, usuario.nombre, genero.nombre as genero, count(voto_musico.fan) as votos, usuario.id_usuario as musico
    from musico
    join genero on genero.id_genero=musico.genero
    join usuario on usuario.id_usuario=musico.id_musico
    join voto_musico on voto_musico.musico = usuario.id_usuario
    join propuesta on propuesta.musico = usuario.id_usuario
    join concierto on propuesta.concierto = concierto.id_concierto
    where id_concierto='$id' and propuesta.aceptado = 0
    group by usuario.id_usuario";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function assignConcert($concert, $music, $assign) {
    $con = connect("proyecto");
    $update = "update propuesta set aceptado='$assign'
    where concierto='$concert' and musico='$music'";
    mysqli_query($con, $update);
    $update = "update concierto set asignado ='$assign' where id_concierto='$concert'";
    mysqli_query($con, $update);
    disconnect($con);
}

function insertConcierto($day, $month, $year, $hour, $min, $pay, $local, $genre) {
    $con = connect("proyecto");
    $insert = "insert into concierto(dia,hora,pago,local,genero,asignado) 
    values('$year-$month-$day','$hour:$min:00',$pay,$local,$genre,0)";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function concCreatedLoc($id) {
    $con = connect("proyecto");
    $select = "select concierto.id_concierto, date_format(concierto.dia, '%d-%m-%Y') as dia, time_format(concierto.hora, '%H:%i') as hora, genero.nombre as genero, concierto.pago, count(propuesta.musico) as inscritos
    from concierto 
    left join propuesta on propuesta.concierto = concierto.id_concierto
    join usuario on concierto.local = usuario.id_usuario
    join genero on concierto.genero = genero.id_genero
    where concierto.asignado = 0 and usuario.id_usuario = '$id'
    group by concierto.id_concierto, concierto.dia, concierto.hora, genero.nombre, concierto.pago
    order by concierto.dia asc limit 7";
    $result = mysqli_query($con, $select);
    disconnect($con);
    return $result;
}

function concAssignLoc($id) {
    $con = connect("proyecto");
    $select = "select usuario.id_usuario as idmusico, concierto.id_concierto as concierto, date_format(concierto.dia, '%d-%m-%Y') as dia, time_format(concierto.hora, '%H:%i') as hora, genero.nombre as genero, usuario.nombre as musico, concierto.pago, count(voto_concierto.fan) as votos
    from concierto
    join genero on concierto.genero = genero.id_genero
    join propuesta on concierto.id_concierto = propuesta.concierto
    join usuario on propuesta.musico = usuario.id_usuario 
    left join voto_concierto on voto_concierto.concierto = concierto.id_concierto
    where propuesta.aceptado = 1 and concierto.local = '$id' 
    group by usuario.id_usuario, concierto.id_concierto, voto_concierto.concierto, concierto.dia, concierto.hora, genero.nombre, usuario.nombre, concierto.pago";
    $result = mysqli_query($con, $select);
    disconnect($con);
    return $result;
}

////////////////
//   MUSICO   //
////////////////

function addMusicProp($musicId, $conId) {
    $con = connect("proyecto");
    $insert = "insert into propuesta values('$conId','$musicId',0)";
    mysqli_query($con, $insert);
    disconnect($con);
}

function delMusicProp($musicId, $conId) {
    $con = connect("proyecto");
    $delete = "delete from propuesta where concierto='$conId' and musico='$musicId'";
    mysqli_query($con, $delete);
    disconnect($con);
}

function getMusicGeneroById($id) {
    $con = connect("proyecto");
    $query = "select genero.nombre from genero
    join musico on musico.genero = genero.id_genero
    where musico.id_musico = '$id'";
    $res = mysqli_query($con, $query);
    $row = mysqli_fetch_array($res);
    disconnect($con);
    return $row["nombre"];
}

function musicSignedUp($musicId, $conId) {
    $con = connect("proyecto");
    $query = "select musico,concierto from propuesta where musico='$musicId' and concierto='$conId'";
    $res = mysqli_query($con, $query);
    $row = mysqli_num_rows($res);
    disconnect($con);
    if ($row > 0)
        return true;
    else
        return false;
}

function MusicoPendienteAsignar() {
    $con = connect("proyecto");
    $select = "select concierto.id_concierto, date_format(concierto.dia, '%d-%m-%Y') as dia, time_format(concierto.hora, '%H:%i') as hora, municipios.municipio as ciudad, usuario.nombre as local, 
    genero.nombre as genero, concierto.pago, count(propuesta.musico) as inscritos
    from propuesta
    join concierto on propuesta.concierto=concierto.id_concierto
    join usuario on concierto.local=usuario.id_usuario
    join municipios on usuario.ciudad=municipios.id
    join genero on concierto.genero=genero.id_genero
    where concierto.asignado = 0
    group by concierto.dia, concierto.hora, municipios.municipio, propuesta.concierto, usuario.nombre, genero.nombre, concierto.pago
    order by concierto.dia asc limit 7";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}

function MusicoAsignado($id) {
    $con = connect("proyecto");
    $select = "select date_format(concierto.dia, '%d-%m-%Y') as dia, time_format(concierto.hora, '%H:%i') as hora, municipios.municipio as ciudad, usuario.nombre as loc, local.direccion, concierto.pago
    from concierto
    join usuario on usuario.id_usuario = concierto.local
    join municipios on usuario.ciudad=municipios.id
    join local on local.id_local = usuario.id_usuario
    join propuesta on propuesta.concierto=concierto.id_concierto
    where propuesta.aceptado = 1 and propuesta.musico = '$id' 
    order by concierto.dia asc limit 7";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}

/////////////
//   FAN   //
/////////////


function FanVotaConciertos() {
    $con = connect("proyecto");
    $select = "select date_format(concierto.dia, '%d-%m-%Y') as dia, time_format(concierto.hora, '%H:%i') as hora, municipios.municipio, local.nombre as local, musico.nombre as musico, count(voto_concierto.fan) as votos, concierto.id_concierto
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

function FanVotaMusicos() {
    $con = connect("proyecto");
    $select = "select usuario.imagen, usuario.nombre, genero.nombre as genero, count(voto_musico.fan) as votos, usuario.id_usuario as musico
    from musico
    inner join genero on genero.id_genero=musico.genero
    inner join usuario on usuario.id_usuario=musico.id_musico
    left join voto_musico on voto_musico.musico=usuario.id_usuario
    group by usuario.id_usuario
    order by votos desc, usuario.nombre asc limit 7";
    // Ejecutamos la consulta y recogemos el resultado
    $resultado = mysqli_query($con, $select);
    disconnect($con);
    // devolvemos el resultado
    return $resultado;
}

function fanVoteConcert($concertId, $fanId) {
    $con = connect("proyecto");
    $select = "select voto_concierto.fan
    from voto_concierto
    where voto_concierto.concierto = '$concertId' and voto_concierto.fan = '$fanId'";
    $res = mysqli_query($con, $select);
    $row = mysqli_num_rows($res);
    disconnect($con);
    if ($row > 0)
        return true;
    else
        return false;
}

function fanVoteMusic($musicId, $fanId) {
    $con = connect("proyecto");
    $select = "select voto_musico.fan
    from voto_musico
    where voto_musico.musico = '$musicId' and voto_musico.fan = '$fanId'";
    $res = mysqli_query($con, $select);
    disconnect($con);
    $row = mysqli_num_rows($res);
    if ($row > 0)
        return true;
    else
        return false;
}

function addConVote($fanId, $conId) {
    $con = connect("proyecto");
    $insert = "insert into voto_concierto values('$fanId','$conId')";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function delConVote($fanId, $conId) {
    $con = connect("proyecto");
    $delete = "delete from voto_concierto where fan='$fanId' and concierto='$conId'";
    if (!mysqli_query($con, $delete)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function addMusicVote($fanId, $musicId) {
    $con = connect("proyecto");
    $insert = "insert into voto_musico values('$fanId','$musicId')";
    if (!mysqli_query($con, $insert)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function delMusicVote($fanId, $musicId) {
    $con = connect("proyecto");
    $delete = "delete from voto_musico where fan='$fanId' and musico='$musicId'";
    if (!mysqli_query($con, $delete)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

//
// Funciones comunes en los tres perfiles
//

function getMunicipioById($id) {
    $con = connect("proyecto");
    $query = "select municipio from municipios where id='$id'";
    $res = mysqli_query($con, $query);
    $row = mysqli_fetch_array($res);
    disconnect($con);
    return $row["municipio"];
}

///////////////////////
//   EDITAR PERFIL   //
///////////////////////

function updateUserEmail($id, $email) {
    $con = connect("proyecto");
    $update = "update usuario set mail = '$email' where id_usuario='$id'";
    if (!mysqli_query($con, $update)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function updateUserPass($id, $pass) {
    $con = connect("proyecto");
    $update = "update usuario set password = '$pass' where id_usuario='$id'";
    if (!mysqli_query($con, $update)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function updateProfileImage($filename, $id) {
    $con = connect("proyecto");
    $update = "update usuario set imagen = '$filename' where id_usuario='$id'";
    if (!mysqli_query($con, $update)) {
        echo mysqli_error($con);
    }
    disconnect($con);
}

function getProvIdByMunicipioId($id) {
    $con = connect("proyecto");
    $query = "select provincias.id from provincias
    join municipios on municipios.provincia_id = provincias.id
    where municipios.id = '$id'";
    $res = mysqli_query($con, $query);
    $row = mysqli_fetch_array($res);
    disconnect($con);
    return $row["id"];
}

function getMunicipiosByProvId($id) {
    $con = connect("proyecto");
    $query = "select municipios.id, municipios.municipio from municipios
    join provincias on municipios.provincia_id = provincias.id
    where provincias.id = '$id'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function checkPass($pass, $id) {
    $con = connect("proyecto");
    $select = "select password from usuario where password = '$pass' and id_usuario = '$id'";
    $res = mysqli_query($con, $select);
    $rows = mysqli_num_rows($res);
    disconnect($con);
    if ($rows > 0)
        return true;
    else
        return false;
}

//
// LOCAL
//

function getLocalDataById($id) {
    $con = connect("proyecto");
    $query = "select aforo,direccion from local where id_local='$id'";
    $res = mysqli_query($con, $query);
    disconnect($con);
    return $res;
}

function updateLocalProfile($id, $nombre, $aforo, $ciudad, $dir, $tlf, $web) {
    $con = connect("proyecto");
    $tlf = ($tlf == '' ? "NULL" : $tlf);
    $web = ($web == '' ? "NULL" : "'" . $web . "'");
    $update = "update usuario set nombre = '$nombre', ciudad = $ciudad, telefono = $tlf, web = $web where id_usuario='$id'";
    if (!mysqli_query($con, $update)) {
        echo mysqli_error($con);
    }
    $update = "update local set aforo = '$aforo', direccion = '$dir' where id_local = '$id'";
    mysqli_query($con, $update);
    disconnect($con);
}

//////////////////////////////////////////////


function selectEmail($email) {
    $con = connect("proyecto");
    $select = "select mail from usuario where mail = '$email'";
    $res = mysqli_query($con, $select);
    disconnect($con);
    return $res;
}

function connect($database) {
    $con = mysqli_connect("localhost", "root", "", $database)
            or die("No se ha podido conectar a la BBDD");
    mysqli_set_charset($con, "utf8");
    return $con;
}

function disconnect($con) {
    mysqli_close($con);
}

?>