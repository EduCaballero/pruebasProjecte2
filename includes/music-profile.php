<?php
if (basename($_SERVER['PHP_SELF']) == "musico.php") {
    $imgsrc = "img/";
} else {
    $imgsrc = "../img/";
}
?>

<div class="content-container">
    <div id="profileImg"><a href=""><img src="<?php echo $imgsrc . $userData["imagen"] ?>" alt=""></a></div>
    <div id="profile-data">
        <h2><?php echo $userData["nombre"] ?></h2>
        <ul id="profile-data-sub">
            <li>
                <span class="fa fa-music icon-profile"></span><span><?php echo getMusicGeneroById($_SESSION["id"]) ?></span>
            </li>
            <li>
                <span class="fa fa-lg fa-map-marker icon-profile"></span><span><?php echo getMunicipioById($userData["ciudad"]) ?></span>
            </li>
            <?php if (isset($userData["telefono"])) { ?>
                <li>
                    <span class="fa fa-lg fa-phone icon-profile"></span><span><?php echo $userData["telefono"] ?></span>
                </li>
            <?php } ?>
            <li>
                <span class="fa fa-envelope icon-profile"></span><span><?php echo $userData["mail"] ?></span>
            </li>
            <?php
            if (isset($userData["web"])) {
                $url = explode("://", $userData["web"], 2);
                ?>
                <li>
                    <span class="fa fa-link icon-profile"></span><a href="<?php echo $userData["web"] ?>"><span><?php echo $url[1] ?></span></a>
                </li>
            <?php } ?>

        </ul>
    </div>
</div>