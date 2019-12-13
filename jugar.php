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

            if (isset($_POST['crea-partida'])) {
                DB::setGame($_POST['nombre'], $_POST['desc']);
                $usuario = DB::getUser($_SESSION['id']);
                $partida = DB::getGame($_POST['nombre']);
                DB::setUserGame($usuario->getId_user(), $partida->getId_game(), "1");
            }

            if (isset($_POST['unirse'])) {
                $usuario = DB::getUser($_SESSION['id']);

                DB::setUserGame($usuario->getId_user(),$_POST['idpartida'], 0);
            }

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
                        foreach ($partidas as $part) {
                            $userGame = DB::getUsersGame($part->getId_game());
                            $yaunido = false;
                            echo '<div class="gamebox"><h4>'.$part->getNameg().'</h4><p class="about">'.$part->getAbout().'</p><br>
                                 Director de juego: ';
                            foreach ($userGame as $user) {
                                if ($user->getDirector() == 1) {
                                    $countPlayers++;
                                    $usuario = DB::getUserId($user->getId_user());
                                    echo '<div class="director">'.$usuario->getNick().'<span class="director-desc">'.$usuario->getAbout().'</span></div>';
                                }
                            }
                            echo '<br><br>'; 
                            echo '<div>Participantes: ';
                            $countPlayers = 0;
                            foreach ($userGame as $user) {
                                $countPlayers++;
                                if ($user->getDirector() == 0) {
                                    $usuario = DB::getUserId($user->getId_user());
                                    echo '<div class="jugador">'.$usuario->getNick().' '.'<span class="jugador-desc">'.$usuario->getAbout().'</span></div>';
                                }
                            }

                            $userLogged = DB::getUser($_SESSION['id']);
                            
                            foreach ($userGame as $user) {
                                if($user->getId_user() == $userLogged->getId_user() && ($user->getId_game() == $part->getId_game())) {
                                    $yaunido = true;
                                }
                            }
                            

                            if (($countPlayers < 4) && (!$yaunido)) {
                                
                                echo '<form method = "POST">
                                    <input type="hidden" name="idpartida" value="'.$part->getId_game().'" id="boton-unir"></input>
                                    <input type="submit" name="unirse" value="Unirse" id="boton-unir"></input>
                                    </form>';
                                
                            }
                            else if (($countPlayers < 4) && ($yaunido)) {
                                echo "<br><br><p style='font-style: italic; color: red;'>Ya estás inscrito en esta partida</p>";
                            }
                            else {
                                echo "<br><br><p style='font-style: italic; color: red;'>Cupo de jugadores completo</p>";
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <div class="col-sm-4" id="crea-partida">
                    
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