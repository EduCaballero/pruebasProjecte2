<?php
if ($_SESSION["tipo"] == "L") {
    if (basename($_SERVER['PHP_SELF']) == "editlocal.php") {
        $user_url = "../local.php";
        $profile_url = "editlocal.php";
        $logout_url = "../logout.php";
    } else {
        $user_url = "local.php";
        $profile_url = "local/editlocal.php";
        $logout_url = "logout.php";
    }
} else if ($_SESSION["tipo"] == "M") {
    if (basename($_SERVER['PHP_SELF']) == "editmusico.php") {
        $user_url = "../musico.php";
        $profile_url = "editmusico.php";
        $logout_url = "../logout.php";
    } else {
        $user_url = "musico.php";
        $profile_url = "musico/editmusico.php";
        $logout_url = "logout.php";
    }
} else if ($_SESSION["tipo"] == "F") {
    if (basename($_SERVER['PHP_SELF']) == "editfan.php") {
        $user_url = "../fan.php";
        $profile_url = "editfan.php";
        $logout_url = "../logout.php";
    } else {
        $user_url = "fan.php";
        $profile_url = "fan/editfan.php";
        $logout_url = "logout.php";
    }
}
?>
<nav id="mobile-menu" class="mobile-menu">
    <div class="mobile-menu-top">ConcertPush</div>
    <ul>
        <li class="mobile-menu-item">
            <a href="<?php echo $user_url; ?>" class="mobile-menu-link"><span class="fa fa-user"></span>Usuario</a>
        </li>
        <li class="mobile-menu-item">
            <a href="<?php echo $profile_url; ?>" class="mobile-menu-link"><span class="fa fa-pencil-square"></span>Editar Perfil</a>
        </li>
        <li class="mobile-menu-item">
            <a href="<?php echo $logout_url; ?>" class="mobile-menu-link"><span class="fa fa-times"></span>Salir</a>
        </li>
    </ul>
</nav>
<div id="overlay"></div>
<div id="topbar">
    <div id="top-menu">
        <div class="logo">
            <a href="<?php echo $user_url; ?>" title="ConcertPush" class="logo-link">ConcertPush</a>
        </div><div id="mobile-button-container">
            <div class="mobile-menu-button" title="Abrir menú">
                <span class="fa fa-bars"></span></div>
        </div><form class="search-box" action="search.php" method="GET">
            <div id="inner-search-wrap">
                <i class="fa fa-search search-icon"></i>
                <input id="search-field" type="search" placeholder="Busca en ConcertPush" name="search"><button id="search-submit" type="input"><span class="fa fa-search"></span></button>
            </div>
        </form>
        <nav id="user-menu">
            <ul>
                <li class="user-menu-item">
                    <a href="<?php echo $user_url; ?>" class="user-menu-link">USUARIO</a>
                </li><li class="user-menu-item">
                    <a href="<?php echo $profile_url; ?>" class="user-menu-link">EDITAR PERFIL</a>
                </li><li class="user-menu-item">
                    <a href="<?php echo $logout_url; ?>" class="user-menu-link">SALIR</a>
                </li>
            </ul>
        </nav>
    </div>
</div>


