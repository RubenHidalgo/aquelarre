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
                $showLogin = true;
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
            <div class="row">
                <div class="col-sm-4"><h1><?php echo $_GET['user']; ?></h1></div>
                <div class="col-sm-8">
                    <button class="btn btn-secondary">
                    <a href="panel.php?userdeleted=<?php echo $_GET['user']; ?>"
                    onclick="return confirm('¿Estás seguro de eliminar al usuario? También se borrará cualquier partida creada por el usuario.');">Eliminar usuario</a>
                    </button>
                </div>
            </div>
            <hr>            
            <div class="row">
                <div class="col-sm-2">
                    <p><b>Fecha de registro: </b></p>
                </div>
                <div class="col-sm-10">
                    <?php 
                        $usuario = DB::getUser($_GET['user']);
                        echo '<p>'.$usuario->getFecha().'</p>';
                    ?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-2">
                    <p><b>Registro de accesos: </b></p>
                </div>
                <div class="col-sm-10">
                    <?php 
                        $accesos = DB::getLog($_GET['user']);
                        foreach ($accesos as $access) {
                            echo date("H:i:s, d/m/Y", strtotime($access->getAcceso()));
                            echo '<br>';
                        }
                        
                    ?>
                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-sm-2">
                    <p><b>Partidas activas: </b></p>
                </div>
                <div class="col-sm-10">
                    <?php 
                        $partidas = DB::getGames();
                        foreach ($partidas as $part) {
                            $userGame = DB::getUsersGame($part->getId_game());
                            
                            foreach ($userGame as $user) {
                                if($user->getId_user() == $usuario->getId_user() && ($user->getId_game() == $part->getId_game())) {
                                    echo $part->getNameg().'<br>';
                                }
                            }
                        }
                        
                    ?>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>