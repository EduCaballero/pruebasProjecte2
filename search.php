<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ConcertPush - Buscar</title>
        <script src="js/src/modal.js"></script>
        <link rel="stylesheet" href="css/font-awesome.css">
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Open+Sans|Roboto" rel="stylesheet">
        <link href="css/search.css" rel="stylesheet" type="text/css"/>
        <script src="js/src/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="js/src/search.js" type="text/javascript"></script>
        <script src="js/src/mobile.js" type="text/javascript"></script>
    </head>
    <body>
        <?php require_once 'bbdd.php'; ?>
        <header>
            <?php
            session_start();
            if (isset($_SESSION["tipo"])) {
                require_once 'includes/header-intranet.php';
            } else {
                ?>
                <nav id="mobile-menu" class="mobile-menu">
                    <div class="mobile-menu-top">ConcertPush</div>
                    <ul>
                        <li class="mobile-menu-item"><a class="mobile-menu-link" href="signin.php"><span class="fa fa-user"></span>Iniciar sesión</a></li>
                        <li class="mobile-menu-item"><a class="mobile-menu-link" href="signup.php"><span class="fa fa-pencil-square"></span>Regístrate</a></li>
                    </ul>
                    <ul>
                        <li class="mobile-menu-item"><a class="mobile-menu-link" href="#"><span class="fa fa-language"></span>Castellano</a></li>
                        <li class="mobile-menu-item"><a class="mobile-menu-link" href="#"><span class="fa fa-language"></span>Catalan</a></li>
                        <li class="mobile-menu-item"><a class="mobile-menu-link" href="#"><span class="fa fa-language"></span>Euskera</a></li>
                        <li class="mobile-menu-item"><a class="mobile-menu-link" href="#"><span class="fa fa-language"></span>Gallego</a></li>
                    </ul>
                </nav>
                <div id="overlay"></div>
                <div id="topbar">
                    <div class="logo">
                        <a href="index.php" title="ConcertPush" class="logo-link">ConcertPush</a>
                    </div><div id="mobile-button-container">
                        <div class="mobile-menu-button" title="Abrir menú">
                            <span class="fa fa-bars"></span></div>
                    </div><form class="search-box" action="" method="GET">
                        <div id="inner-search-wrap">
                            <i class="fa fa-search search-icon"></i>
                            <input id="search-field" type="search" placeholder="Buscar en ConcertPush" name="search"><button id="search-submit" type="submit"><span class="fa fa-search"></span></button>
                        </div>
                    </form>
                    <nav id="user-menu">
                        <div class="dropdown">
                            <a class="dropdown-top" href="#">IDIOMA<span class="fa fa-caret-down"></span></a>
                            <ul class="dropdown-sub">
                                <li class="dropdown-sub-item"><a href="#">CASTELLANO</a></li>
                                <li class="dropdown-sub-item"><a href="#">CATALAN</a></li>
                                <li class="dropdown-sub-item"><a href="#">EUSKERA</a></li>
                                <li class="dropdown-sub-item"><a href="#">GALLEGO</a></li>
                            </ul>
                        </div><div class="signin-signup">
                            <ul>
                                <li class="user-menu-item"><a href="signin.php" class="user-menu-link">INICIAR SESIÓN</a></li><li class="user-menu-item"><a href="signup.php" class="user-menu-link">REGÍSTRATE</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </header>
            <?php
        }
        if (isset($_GET["search"])) {
            ?>
            <div id="container">
                <form id="options" method="get">
                    <input type="hidden" name="search" value="<?php echo $_GET["search"] ?>">
                    <div class="opt-title">
                        <h3>Tipo</h3>   
                    </div>
                    <div class="opt-body">
                        <ul>
                            <?php
                            if (isset($_GET["type"]) && in_array("M", $_GET["type"])) {
                                echo '
                                <li>
                                    <input id="chbx-m" type="checkbox" name="type[]" value="M" checked><label for="chbx-m">Musico</label>
                                </li>';
                            } else {
                                echo '
                                <li>
                                    <input id="chbx-m" type="checkbox" name="type[]" value="M"><label for="chbx-m">Musico</label>
                                </li>';
                            }
                            if (isset($_GET["type"]) && in_array("L", $_GET["type"])) {
                                echo '
                                <li>
                                    <input id="chbx-l" type="checkbox" name="type[]" value="L" checked><label for="chbx-l">Local</label>
                                </li>';
                            } else {
                                echo '
                                <li>
                                    <input id="chbx-l" type="checkbox" name="type[]" value="L"><label for="chbx-l">Local</label>
                                </li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="opt-title">
                        <h3>Genero</h3>   
                    </div>
                    <div class="opt-body">
                        <ul>
                            <?php
                            $firstGen = getFirstGen();
                            while ($row = mysqli_fetch_array($firstGen)) {
                                if (isset($_GET["genre"]) && in_array($row["id_genero"], $_GET["genre"])) {
                                    echo ' 
                                    <li>
                                        <input id="chbx-prov-' . $row["id_genero"] . '" type="checkbox" name="genre[]" value="' . $row["id_genero"] . '" checked> <label for="chbx-prov-' . $row["id_genero"] . '">' . $row["nombre"] . '</label>
                                    </li>';
                                } else {
                                    echo ' 
                                    <li>
                                        <input id="chbx-gen-' . $row["id_genero"] . '" type="checkbox" name="genre[]" value="' . $row["id_genero"] . '"> <label for="chbx-gen-' . $row["id_genero"] . '">' . $row["nombre"] . '</label>
                                    </li>';
                                }
                            }
                            ?>
                        </ul>
                        <ul id="rest-gen">
                            <?php
                            $restGen = getRestGen();
                            while ($row = mysqli_fetch_array($restGen)) {
                                if (isset($_GET["genre"]) && in_array($row["id_genero"], $_GET["genre"])) {
                                    echo ' 
                                    <li>
                                        <input id="chbx-prov-' . $row["id_genero"] . '" type="checkbox" name="genre[]" value="' . $row["id_genero"] . '" checked> <label for="chbx-prov-' . $row["id_genero"] . '">' . $row["nombre"] . '</label>
                                    </li>';
                                } else {
                                    echo ' 
                                    <li>
                                        <input id="chbx-gen-' . $row["id_genero"] . '" type="checkbox" name="genre[]" value="' . $row["id_genero"] . '"> <label for="chbx-gen-' . $row["id_genero"] . '">' . $row["nombre"] . '</label>
                                    </li>';
                                }
                            }
                            ?>
                        </ul>
                        <div id="show-more-gen" class="more"><p>Mostrar más<i class="fa fa-lg fa-angle-down"></i></p></div>
                        <div id="show-less-gen" class="less"><p>Mostrar menos<i class="fa fa-lg fa-angle-up"></i></p></div>
                    </div>
                    <div class="opt-title">
                        <h3>Provincia</h3>   
                    </div>
                    <div id="opt-prov" class="opt-body">
                        <ul>
                            <?php
                            $firstProv = getFirstProv();
                            while ($row = mysqli_fetch_array($firstProv)) {
                                if (isset($_GET["prov"]) && in_array($row["id"], $_GET["prov"])) {
                                    echo ' 
                                    <li>
                                        <input id="chbx-prov-' . $row["id"] . '" type="checkbox" name="prov[]" value="' . $row["id"] . '" checked> <label for="chbx-prov-' . $row["id"] . '">' . $row["provincia"] . '</label>
                                    </li>';
                                } else {
                                    echo ' 
                                    <li>
                                        <input id="chbx-prov-' . $row["id"] . '" type="checkbox" name="prov[]" value="' . $row["id"] . '"> <label for="chbx-prov-' . $row["id"] . '">' . $row["provincia"] . '</label>
                                    </li>';
                                }
                            }
                            ?>
                        </ul>
                        <ul id="rest-prov">
                            <?php
                            $restProv = getRestProv();
                            while ($row = mysqli_fetch_array($restProv)) {
                                if (isset($_GET["prov"]) && in_array($row["id"], $_GET["prov"])) {
                                    echo ' 
                                    <li>
                                        <input id="chbx-prov-' . $row["id"] . '" type="checkbox" name="prov[]" value="' . $row["id"] . '" checked> <label for="chbx-prov-' . $row["id"] . '">' . $row["provincia"] . '</label>
                                    </li>';
                                } else {
                                    echo ' 
                                    <li>
                                        <input id="chbx-prov-' . $row["id"] . '" type="checkbox" name="prov[]" value="' . $row["id"] . '"> <label for="chbx-prov-' . $row["id"] . '">' . $row["provincia"] . '</label>
                                    </li>';
                                }
                            }
                            ?>
                        </ul>
                        <div id="show-more-prov" class="more"><p>Mostrar más<i class="fa fa-lg fa-angle-down"></i></p></div>
                        <div id="show-less-prov" class="less"><p>Mostrar menos<i class="fa fa-lg fa-angle-up"></i></p></div>
                    </div>
                    <div id="opt-submit"> 
                        <input type="submit" value="Filtrar" name="filtrar" class="btn btn-opt">
                    </div>
                </form><div id="card-container">
                    <?php
                    $typeFilter = "";
                    if (isset($_GET["type"])) {
                        $type = $_GET["type"];
                        for ($i = 0; $i < count($type); $i++) {
                            $typeFilter = $typeFilter . "'$type[$i]'";
                            if ($i < count($type) - 1) {
                                $typeFilter = $typeFilter . ",";
                            }
                        }
                        $typeFilter = "usuario.tipo in ($typeFilter)";
                        $typeFilter = " and ".$typeFilter;
                    }
                    $genFilter = "";
                    if (isset($_GET["genre"])) {
                        $gen = $_GET["genre"];
                        for ($i = 0; $i < count($gen); $i++) {
                            $genFilter = $genFilter . "$gen[$i]";
                            if ($i < count($gen) - 1) {
                                $genFilter = $genFilter . ",";
                            }
                        }
                        $genFilter = "genero.id_genero in ($genFilter)";
                        if (!empty($typeFilter)) {
                            $genFilter = " and " . $genFilter;
                        }
                    }
                    $provFilter = "";
                    if (isset($_GET["prov"])) {
                        $prov = $_GET["prov"];
                        for ($i = 0; $i < count($prov); $i++) {
                            $provFilter = $provFilter . "$prov[$i]";
                            if ($i < count($prov) - 1) {
                                $provFilter = $provFilter . ",";
                            }
                        }
                        $provFilter = "municipios.provincia_id in ($provFilter)";
                        if (!empty($typeFilter)) {
                            $provFilter = " and " . $provFilter;
                        }
                    }
                    if (isset($_GET["filtrar"])) {
                        $musics = getFilteredMusic($_GET["search"], $typeFilter, $genFilter);
                        $locals = getFilteredLocal($_GET["search"], $typeFilter, $provFilter);
                    } else {
                        $musics = getQueryMusic($_GET["search"]);
                        $locals = getQueryLocal($_GET["search"]);
                    }
                    
                    if (mysqli_num_rows($musics) > 0) {
                        echo '
                    <div class="res-title">
                        <h1>Musicos</h1>
                    </div>';
                        while ($row = mysqli_fetch_array($musics)) {
                            $musicQuery = getMusicSearch($row["id_usuario"]);
                            $musicData = mysqli_fetch_array($musicQuery);
                            ?>
                            <div class="card">
                                <div class="card-content">
                                    <h3 class="name"><?php echo $musicData["nombre"] ?></h3>
                                    <h4 class="genre-addr"><?php echo $musicData["genero"] ?></h4>
                                    <div class="card-body">
                                        <div class="card-img"><img src="img/<?php echo $musicData["imagen"] ?>"></div><div class="card-info">
                                            <div class="prox-conc">Proximos conciertos</div>
                                            <table class="card-conc">
                                                <?php
                                                $musicConc = MusicoAsignado($row["id_usuario"]);
                                                if (mysqli_num_rows($musicConc) == 0) {
                                                    echo 'No hay conciertos';
                                                } else {
                                                    while ($row = mysqli_fetch_array($musicConc)) {
                                                        echo "
                                                <tr>
                                                    <td>" . $row["dia"] . "</td>
                                                    <td title='" . $row["loc"] . "'>" . $row["loc"] . "</td>
                                                    <td>" . $row["hora"] . "</td>
                                                </tr>
                                                ";
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } 
                    if (mysqli_num_rows($locals) > 0) {
                        echo '
                    <div class="res-title">
                        <h1>Locales</h1>
                    </div>';
                        while ($row = mysqli_fetch_array($locals)) {
                            $localQuery = getLocalSearch($row["id_usuario"]);
                            $localData = mysqli_fetch_array($localQuery);
                            ?>
                            <div class="card">
                                <div class="card-content">
                                    <h3 class="name"><?php echo $localData["nombre"] ?></h3>
                                    <h4 class="genre-addr"><?php echo $localData["municipio"] ?></h4>
                                    <div class="card-body">
                                        <div class="card-img">
                                            <img src="img/<?php echo $localData["imagen"] ?>">
                                        </div><div class="card-info">
                                            <div class="addr"><?php echo $localData["direccion"] ?></div>
                                            <div class="mail-local"><?php echo $localData["mail"] ?></div><div class="tlf-local"><?php echo $localData["telefono"] ?></div>
                                            <div class="prox-conc">Proximos conciertos</div>                                          
                                            <table class="card-conc">
                                                <?php
                                                $localConc = concAssignLoc($row["id_usuario"]);
                                                if (mysqli_num_rows($localConc) == 0) {
                                                    echo 'No hay conciertos';
                                                } else {
                                                    while ($row = mysqli_fetch_array($localConc)) {
                                                        echo "
                                                <tr>
                                                    <td>" . $row["dia"] . "</td>
                                                    <td title='" . $row["musico"] . "'>" . $row["musico"] . "</td>
                                                    <td>" . $row["hora"] . "</td>
                                                </tr>
                                                ";
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } if (mysqli_num_rows($musics) == 0 && mysqli_num_rows($locals) == 0) {
                        echo '
                        <div class="res-title">
                            <h1>No hay resultados para "' . $_GET["search"] . '"</h1>
                        </div>
                        <div id="no-results">
                            <p>No se han encontrado resultados con el criterio de búsqueda seleccionado. Prueba con otra búsqueda similar o más simple.</p>
                        </div>';
                    }
                    ?>
                </div>
                <footer class="footer">
                    <?php require_once 'includes/footer.php'; ?>
                </footer>
            </div>
        <?php } ?>
    </body>
</html>
