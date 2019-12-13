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
                DB::setUserGame($usuario->getId_user(), $partida->getId_game(), "1");
            }

            //Esta función une al usuario a una partida en curso
            if (isset($_POST['unirse'])) {
                $usuario = DB::getUser($_SESSION['id']);

                DB::setUserGame($usuario->getId_user(),$_POST['idpartida'], 0);
            }

            //Cargamos la lista de partidas
            $partidas = DB::getGames();
        ?> 
        <nav class="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php
                    if (isset($_SESSION['id'])) {
                        echo "<li><a href='jugar.php'>Jugar</a></li>";
                    }
                
                    if (isset($_SESSION['id'])) {
                        echo "<li><a href='cuenta.php'>Mi cuenta</a></li>";
                    }
                ?>
                <li><img src="media/logo.png" alt="Logo Aquelarre" id="logo"></li>
                <div class="right">
                    <form method="post">
                        <?php
                            if ($showLogin) {
                                echo "<li><input type='text' name='user' placeholder='Usuario'></li>";
                                echo "<li><input type='text' name='password' placeholder='Contraseña'></li>";
                                echo "<li><input type='submit' name ='login' value='Acceso/Registro'></li>";
                            }
                            else {
                                echo "<li><p style='color:white;padding-right:10px;'>Bienvenido, ".$_SESSION['id']."</p></li>";
                                echo "<li><input type='submit' name='logout' value='Desconectar'></li>";
                            }
                        ?>
                    </form>
                </div>
            </ul>
        </nav>
        
        <div class="main">
            <div class="row">
                <div class="col-sm-8">
                    <h3>Lista de partidas</h3>
                    <?php 
                        //Recorremos la lista de partidas creadas
                        foreach ($partidas as $part) {
                            $userGame = DB::getUsersGame($part->getId_game());
                            $yaunido = false;
                            $countPlayers = 0; //Cuenta de los jugadores que hay en cada partida

                            echo '<div class="gamebox"><h4>'.$part->getNameg().'</h4><p class="about">'.$part->getAbout().'</p><br>
                                 Director de juego: ';
                            
                            //Comprobamos qué usuario es el director de juego
                            foreach ($userGame as $user) {
                                if ($user->getDirector() == 1) {
                                    $countPlayers++;
                                    $usuario = DB::getUserId($user->getId_user());
                                    echo '<div class="director">'.$usuario->getNick().'<span class="director-desc">'.$usuario->getAbout().'</span></div>';
                                }
                            }
                            echo '<br><br>'; 
                            echo '<div>Participantes: ';
                            //Comprobamos ahora los jugadores, y seguimos aumentando el contador
                            foreach ($userGame as $user) {
                                if ($user->getDirector() == 0) {
                                    $countPlayers++;
                                    $usuario = DB::getUserId($user->getId_user());
                                    echo '<div class="jugador">'.$usuario->getNick().' '.'<span class="jugador-desc">'.$usuario->getAbout().'</span></div>';
                                }
                            }

                            //Cargamos los datos del usuario logueado, y comprobamos si ya está unido a una partida. De esta forma, más abajo 
                            //desactivamos el botón para unirse
                            $userLogged = DB::getUser($_SESSION['id']);
                            
                            foreach ($userGame as $user) {
                                if($user->getId_user() == $userLogged->getId_user() && ($user->getId_game() == $part->getId_game())) {
                                    $yaunido = true;
                                }
                            }
                            
                            //Si hay menos de 4 jugadores y el jugador no se ha unido, activamos el botón de unirse
                            if (($countPlayers < 4) && (!$yaunido)) {
                                
                                echo '<form method = "POST">
                                    <input type="hidden" name="idpartida" value="'.$part->getId_game().'"></input>
                                    <input type="submit" name="unirse" value="Unirse" id="boton-unir"></input>
                                    </form>';
                                
                            }
                            //Si el jugador se ha unido y hay 4 jugadores, activamos el botón para jugar a la partida
                            else if (($countPlayers == 4) && ($yaunido)) {
                                echo '<form method = "POST">
                                    <input type="hidden" name="idpartida" value="'.$part->getId_game().'"></input>
                                    <input type="submit" name="jugar" value="Jugar" id="boton-jugar"></input>
                                    </form>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <div class="col-sm-4" id="crea-partida">
                        
                        <!-- Formulario para crear una partida -->
                        <h4>Crea una partida</h4>
                        <br><br>
                        <form method="POST">
                            <label for="nombre"><b>Nombre</b></label>
                            <input type="text" name="nombre" id="nombre-partida" required>
                            <br><br>
                            <label for="desc"><b>Descripción</b></label>
                            <input type="text" name="desc" id="desc-partida" required>
                            <br><br>
                            <button type="submit" name="crea-partida">Crear</button>
                        </form>
                    
                </div>
            </div>
        </div>
    </body>
</html>