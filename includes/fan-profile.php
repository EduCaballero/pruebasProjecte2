<?php
if (basename($_SERVER['PHP_SELF']) == "fan.php") {
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
        </ul>
    </div>
</div>