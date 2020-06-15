<!-- Rubén Hidalgo González - Proyecto fin de ciclo -->

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Aquelarr-e</title>
        <meta name="description" content="Tu mesa de rol virtual ">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type='text/javascript' src='http://code.jquery.com/jquery.min.js'></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        <script>
            $(document).ready(function(){
                $("#selectgame").change(function(){
                    $(this).find("option:selected").each(function(){
                        var optionValue1 = $(this).attr("value");
                        if(optionValue1){
                            $(".game").not("." + optionValue1).hide();
                            $("." + optionValue1).show();
                        } else{
                            $(".game").hide();
                        }
                    });
                }).change();
                $("#selectuser").change(function(){
                    $(this).find("option:selected").each(function(){
                        var optionValue2 = $(this).attr("value");
                        if(optionValue2){
                            $(".user").not("." + optionValue2).hide();
                            $("." + optionValue2).show();
                        } else{
                            $(".user").hide();
                        }
                    });
                }).change();
            });
        </script>
    </head>
    <body>
        <?php
            require_once 'clases/DB.php';
            
            session_start();

            if ($_SESSION['id'] !== 'admin') {
                header("Location:index.php");
            }
            
            //Si el usuario se desloguea, liberamos la variable de sesión y mostramos el menú de login mediante $showLogin 
            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                header("Location:index.php");
            }
        ?> 

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
            <a class="navbar-brand" href="index.php">AQUELARRE</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <?php
                    //Si no hay usuario logueado, no cargamos las secciones del menú
                    if (isset($_SESSION['id'])) {
                        $username = $_SESSION['id'];
                        if ($username === 'admin') {

                        }
                        else {
                            echo '<a class="nav-link" href="jugar.php">Jugar</a>';
                        }
                    }
                ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
                <li class="nav-item dropdown">
                    <?php
                        echo '<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                        if ((isset($_SESSION['id'])) && (strcmp($_SESSION['id'],'admin')) === 1) {
                            echo $_SESSION['id'].'</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                            echo '<a class="dropdown-item" href="cuenta.php">Cuenta</a>';
                            echo '<a class="dropdown-item"><form method="post"><input type="submit" name="logout" value="Cerrar sesión"></form></a>';
                            echo '</div>';
                        }
                        else if ((isset($_SESSION['id'])) && (strcmp($_SESSION['id'],'admin')) === 0) {
                            echo $_SESSION['id'].'</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                            echo '<a class="dropdown-item" href="panel.php">Panel de control</a>';
                            echo '<a class="dropdown-item"><form method="post"><input type="submit" name="logout" value="Cerrar sesión"></form></a>';
                            echo '</div>';
                        }
                        else {
                            echo 'Usuario'.'</a>';
                            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                            echo '<a class="dropdown-item" href="login.php">Identificarse</a>';
                            echo '<a class="dropdown-item" href="registro.php">Registrarse</a>';
                            echo '</div>';
                        }
                    ?>
                    
                </li>
                </ul>
            </div>
        </nav>

        <div class="main">            
            <div class="container nav-justified">
                <h3>PANEL DE CONTROL ADMINISTRACIÓN</h3>
                <hr>
                <nav>
                <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">USUARIOS</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">PARTIDAS</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">ARTÍCULOS</a>
                </div>
                </nav>
                <?php
                if (isset($_GET['userdeleted'])) {
                        echo '<br><br>';
                        $delUsuario = DB::getUser($_GET['userdeleted']);
                        $delGames = DB::getGamesDirector($delUsuario->getId_user());
                        DB::delUserGame($delUsuario->getId_user());
                        foreach ($delGames as $delGame) {
                            DB::delGameUser($delGame->getId_game());
                        }
                        foreach ($delGames as $delGame) {
                            DB::delGame($delGame->getId_game());
                        }
                        DB::delUser($_GET['userdeleted']);
                        echo '<div class="alert alert-success" role="alert">Usuario '.$_GET['userdeleted'].'borrado correctamente.</div>';
                }
                if (isset($_GET['gamedeleted'])) {
                    echo '<br><br>';
                    DB::delGameUser($_GET['gamedeleted']);
                    DB::delGame($_GET['gamedeleted']);
                    echo '<div class="alert alert-success" role="alert">Partida borrada correctamente.</div>';
                }
                if (isset($_GET['postdeleted'])) {
                    echo '<br><br>';
                    DB::delPost($_GET['postdeleted']);
                    echo '<div class="alert alert-success" role="alert">Artículo borrado correctamente.</div>';
                }
                ?>
                <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <br><br>
                <div class="row">
                <div class="form-group col-sm-2">
                    <label for="exampleFormControlSelect1">Ordenar por</label>
                    <select class="form-control" id="selectuser">
                    <option value="a">A-Z</option>
                    <option value="b">Z-A</option>
                    <option value="c">Más antigüo</option>
                    <option value="d">Más nuevo</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label for="buscar">Buscar</label>
                    <input class="form-control" id="buscar" type="text" placeholder="Escribe el nick" aria-label="Search" onkeyup="filter(this)">
                    <script language="javascript" type="text/javascript">
                    function filter(element) {
                        var value = $(element).val();
                        $(".theList > li").each(function() {
                            if ($(this).text().search(value) > -1) {
                                $(this).show();
                            }
                            else {
                                $(this).hide();
                            }
                        });
                    }
                </script>
                </div>
                </div>
                <br><br>
                <div class="container">
                    <div class="row" style="font-weight: bold;">
                        <div class="col-sm">
                        Nick
                        </div>
                        <div class="col-sm">
                        Creación
                        </div>
                        <div class="col-sm">
                        Último acceso
                        </div>
                        <div class="col-sm">
                        Partidas en curso
                        </div>
                    </div>
                    <div class="a user">
                    <ul class="theList">
                    <?php
                    
                        $usuarios = DB::getUsersNickAsc();
                        foreach ($usuarios as $user) {
                            if ($user->getNick() !== 'admin') {
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $user->getNick();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $user->getFecha();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $lastLog = DB::getLastLog($user->getNick());
                                echo $lastLog->getAcceso();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroJuegos = DB::getGamesUser($user->getId_user());
                                echo count($numeroJuegos);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="edituser.php?user=<?php echo $user->getNick() ?>" class="btn btn-secondary">Editar usuario</a>
                                <?php
                                echo '</li>';
                            }
                        }
                    ?>
                    </ul>
                    </div>
                    <div class="b user">
                    <ul class="theList">
                    <?php
                        $usuarios = DB::getUsersNickDesc();
                        foreach ($usuarios as $user) {
                            if ($user->getNick() !== 'admin') {
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $user->getNick();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $user->getFecha();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $lastLog = DB::getLastLog($user->getNick());
                                echo $lastLog->getAcceso();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroJuegos = DB::getGamesUser($user->getId_user());
                                echo count($numeroJuegos);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="edituser.php?user=<?php echo $user->getNick() ?>" class="btn btn-secondary">Editar usuario</a>
                                <?php
                                echo '</li>';
                            }
                        }
                    ?>
                    </ul>
                    </div>
                    <div class="c user">
                    <ul class="theList">
                    <?php
                        $usuarios = DB::getUsersASC();
                        foreach ($usuarios as $user) {
                            if ($user->getNick() !== 'admin') {
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $user->getNick();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $user->getFecha();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $lastLog = DB::getLastLog($user->getNick());
                                echo $lastLog->getAcceso();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroJuegos = DB::getGamesUser($user->getId_user());
                                echo count($numeroJuegos);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="edituser.php?user=<?php echo $user->getNick() ?>" class="btn btn-secondary">Editar usuario</a>
                                <?php
                                echo '</li>';
                            }
                        }
                    ?>
                    </ul>
                    </div>
                    <div class="d user">
                    <ul class="theList">
                    <?php
                        $usuarios = DB::getUsersDESC();
                        foreach ($usuarios as $user) {
                            if ($user->getNick() !== 'admin') {
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $user->getNick();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $user->getFecha();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $lastLog = DB::getLastLog($user->getNick());
                                echo $lastLog->getAcceso();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroJuegos = DB::getGamesUser($user->getId_user());
                                echo count($numeroJuegos);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="edituser.php?user=<?php echo $user->getNick() ?>" class="btn btn-secondary">Editar usuario</a>
                                <?php
                                echo '</li>';
                            }
                        }
                        
                    ?>
                    </ul>
                    </div>
                    </div>    
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <br><br>
                <div class="row">
                <div class="form-group col-sm-2">
                    <label for="exampleFormControlSelect1">Ordenar por</label>
                    <select class="form-control" id="selectgame">
                    <option value="e">A-Z</option>
                    <option value="f">Z-A</option>
                    <option value="g">Más antigüo</option>
                    <option value="h">Más nuevo</option>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label for="buscar">Buscar</label>
                    <input class="form-control" id="buscarpart" type="text" placeholder="Escribe el nombre" aria-label="Search" onkeyup="filter(this)">
                    <script language="javascript" type="text/javascript">
                    function filter(element) {
                        var value = $(element).val();
                        $(".theList2 > li").each(function() {
                            if ($(this).text().search(value) > -1) {
                                $(this).show();
                            }
                            else {
                                $(this).hide();
                            }
                        });
                    }
                </script>
                </div>
                </div>
                <br><br>
                <div class="container">
                    <div class="row" style="font-weight: bold;">
                        <div class="col-sm">
                        Nombre
                        </div>
                        <div class="col-sm">
                        Descripción
                        </div>
                        <div class="col-sm">
                        Creación
                        </div>
                        <div class="col-sm">
                        Jugadores
                        </div>
                    </div>
                    <div class="e game">
                    <ul class="theList2">
                    <?php
                    
                        $partidas = DB::getGamesNombreASC();
                        foreach ($partidas as $partida) {
                            
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $partida->getNameg();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getAbout();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getCreated();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroUsers = DB::getUsersGame($partida->getId_game());
                                echo count($numeroUsers);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="editgame.php?game=<?php echo $partida->getId_game() ?>" class="btn btn-secondary">Editar partida</a>
                                <?php
                                echo '</li>';
                            
                        }
                    ?>
                    </ul>
                    </div>
                    <div class="f game">
                    <ul class="theList2">
                    <?php
                    
                        $partidas = DB::getGamesNombreDESC();
                        foreach ($partidas as $partida) {
                            
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $partida->getNameg();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getAbout();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getCreated();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroUsers = DB::getUsersGame($partida->getId_game());
                                echo count($numeroUsers);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="editgame.php?game=<?php echo $partida->getId_game() ?>" class="btn btn-secondary">Editar partida</a>
                                <?php
                                echo '</li>';
                            
                        }
                    ?>
                    </ul>
                    </div>
                    <div class="g game">
                    <ul class="theList2">
                    <?php
                    
                        $partidas = DB::getGamesASC();
                        foreach ($partidas as $partida) {
                            
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $partida->getNameg();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getAbout();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getCreated();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroUsers = DB::getUsersGame($partida->getId_game());
                                echo count($numeroUsers);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="editgame.php?game=<?php echo $partida->getId_game() ?>" class="btn btn-secondary">Editar partida</a>
                                <?php
                                echo '</li>';
                            
                        }
                    ?>
                    </ul>
                    </div>
                    <div class="h game">
                    <ul class="theList2">
                    <?php
                    
                        $partidas = DB::getGamesDESC();
                        foreach ($partidas as $partida) {
                            
                                echo '<li>';
                                echo '<hr>';
                                echo '<div class="row">';
                                echo '<div class="col-sm">';
                                echo $partida->getNameg();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getAbout();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                echo $partida->getCreated();
                                echo '</div>';
                                echo '<div class="col-sm">';
                                $numeroUsers = DB::getUsersGame($partida->getId_game());
                                echo count($numeroUsers);
                                echo '</div>';
                                echo '</div>';
                                echo '<br>';?>
                                <a href="editgame.php?game=<?php echo $partida->getId_game() ?>" class="btn btn-secondary">Editar partida</a>
                                <?php
                                echo '</li>';
                            
                        }
                    ?>
                    </ul>
                    </div>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <br>
                    <div class="row">
                        <div class="form-group col-sm-2">
                            <a href="newpost.php" class="btn btn-primary">Crear artículo</a>
                        </div>
                        
                    </div>
                    <br><br><br>
                        <?php
                            $posts = DB::getPosts();
                            foreach ($posts as $post) {
                                echo '<div class="row">';
                                echo '<h4>'.$post->getTitle().'</h4>';
                                echo '</div>';
                                echo '<br>';
                                echo '<div class="row">';
                                echo '<h5>'.date("d/m/Y, H:i:s", strtotime($post->getCreated())).'</h5>';
                                echo '</div>';
                                echo '<br>';?>
                                <button class="btn btn-secondary">
                                <a href="panel.php?postdeleted=<?php echo $post->getId_post(); ?>"
                                onclick="return confirm('¿Estás seguro de eliminar el post?');">Eliminar artículo</a>
                                </button>
                                <?php
                                echo '<br>';
                                echo '<hr>';
                            }
                        ?>
                        
                    </div>
                    </div>
                </div>
                
            </div>
        </div> 
    </body>
</html>