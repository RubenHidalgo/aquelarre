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
            
            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                $showLogin = true;
                header("Location: index.php");
            }

            if (isset($_POST['login'])) {
                $usuario = DB::getUser($_POST['user']);
                if (count($usuario)==1) {
                    if ($usuario->getPass() == $_POST['password']) {
                        $showLogin = false;
                        $_SESSION['id'] = $usuario->getNick();
                        header("Location: index.php");
                    }
                    else {
                        $showLogin = true;
                    }
                }
                else {
                    $showLogin = true;
                    header("Location: registro.php");
                }
            }

            //Si el usuario hace click en jugar, guardamos la partida en una variable de sesión y cargamos la partida.
            if (isset($_POST['jugar'])) {
                $_SESSION['id_game'] = $_POST['idpartida'];
                header("Location: partida.php");
            }

            //Creamos una nueva partida si el usuario hace click
            if (isset($_POST['crea-partida'])) {
                DB::setGame($_POST['nombre'], $_POST['desc']);
                $usuario = DB::getUser($_SESSION['id']);
                $partida = DB::getGame($_POST['nombre']);
                DB::setUserGame($usuario->getId_user(), $partida->getId_game(), 1, 1, 1, 1, "Director");
            }

            //Esta función une al usuario a una partida en curso
            if (isset($_POST['unirse'])) {
                $_SESSION['id_game'] = $_POST['idpartida'];
                header("Location: creapersonaje.php");
            }

            //Cargamos la lista de partidas
            $partidas = DB::getGames();
            $usuario = DB::getUser($_SESSION['id']);
            $partidasUser = DB::getGamesUser($usuario->getId_user());
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
                        if ((isset($_SESSION['id'])) && ($_SESSION['id'] !== 'admin')) {
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
            <div class="container">
            <div class="row">
                <div class="col col-sm-9" style="max-width: 1200px; margin: 0 auto;">
                    
                    <h3>Lista de partidas</h3>
                    <br><br>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Mis partidas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Buscando jugadores</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <?php
                        foreach ($partidasUser as $part) {
                            $game = DB::getGameId($part->getId_game());
                            $userGame = DB::getUsersGame($game->getId_game());
                            $countPlayers = count($userGame);
                            echo '<div class="gamebox"><h4><b>'.$game->getNameg().'</b></h4><p class="about">'.$game->getAbout().'</p><br>
                                 Director de juego: ';
                            //Comprobamos qué usuario es el director de juego
                            foreach ($userGame as $user) {
                                if ($user->getDirector() == 1) {
                                    $usuario = DB::getUserId($user->getId_user());
                                    echo '<div class="director">'.$usuario->getNick().'<span class="director-desc">'.$usuario->getAbout().'</span></div>';
                                }
                            }
                            echo '<br><br>'; 
                            echo '<div>Participantes: ';
                            //Comprobamos ahora los jugadores, y seguimos aumentando el contador
                            foreach ($userGame as $user) {
                                if ($user->getDirector() == 0) {
                                    $usuario = DB::getUserId($user->getId_user());
                                    echo '<div class="jugador">'.$usuario->getNick().' '.'<span class="jugador-desc">'.$usuario->getAbout().'</span></div>';
                                }
                            }
                            
                            
                            if ($countPlayers > 1) {
                                echo '<form method = "POST">
                                    <br>
                                    <input type="hidden" name="idpartida" value="'.$game->getId_game().'"></input>
                                    <input type="submit" class="btn btn-secondary" name="jugar" value="Jugar" id="boton-jugar"></input>
                                    </form>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                    
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <?php
                        foreach ($partidas as $part) {
                            $yaunido = false;
                            //Obtenemos los usuarios que están en la partida
                            $userGame = DB::getUsersGame($part->getId_game());
                            $countPlayers = count($userGame);
                            foreach ($partidasUser as $partida) {
                                if (($partida->getId_game() == $part->getId_game()) || ($countPlayers > 3)) {
                                    $yaunido = true;
                                }
                            }
                            if (!$yaunido) {
                                echo '<div class="gamebox"><h4><b>'.$part->getNameg().'</b></h4><p class="about">'.$part->getAbout().'</p><br>
                                 Director de juego: ';
                                    //Comprobamos qué usuario es el director de juego
                                foreach ($userGame as $user) {
                                    if ($user->getDirector() == 1) {
                                        $usuario = DB::getUserId($user->getId_user());
                                        echo '<div class="director">'.$usuario->getNick().'<span class="director-desc">'.$usuario->getAbout().'</span></div>';
                                    }
                                }
                                echo '<br><br>'; 
                                echo '<div>Participantes: ';
                                //Comprobamos ahora los jugadores, y seguimos aumentando el contador
                                foreach ($userGame as $user) {
                                    if ($user->getDirector() == 0) {
                                        $usuario = DB::getUserId($user->getId_user());
                                        echo '<div class="jugador">'.$usuario->getNick().' '.'<span class="jugador-desc">'.$usuario->getAbout().'</span></div>';
                                    }
                                }
                                echo '<form method = "POST">
                                    <input type="hidden" name="idpartida" value="'.$part->getId_game().'"></input>
                                    <input type="submit" class="btn btn-secondary" name="unirse" value="Unirse" id="boton-unir"></input>
                                    </form>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    ?>
                    </div>
                    </div>
                    </div>    
                    <div class="col-sm-3" id="crea-partida">
                    <img src="media/LogoAquelarre.gif" class="rounded mx-auto d-block" alt="...">
                        
                        <!-- Formulario para crear una partida -->
                        <br><br>
                        <h4>Crea una partida</h4>
                        <br>
                        <form method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombre-partida" required>
                            </div>
                            <br><br>
                            <div class="form-group">
                            <label for="desc">Descripción</label>
                            <input type="text" class="form-control" name="desc" id="desc-partida" required>
                            </div>
                            <br><br>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="crea-partida">Crear</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            
                   
            </div>
            </div>
        </div>
    </body>
</html>