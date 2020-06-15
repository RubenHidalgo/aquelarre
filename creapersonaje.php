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
        <script>alert($_POST['playerName']);</script>
    </head>
    <body>
    
        <?php
            require_once 'clases/DB.php';
            
            session_start();
            
            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                $showLogin = true;
            }

            //Si pulsamos el botón de registro, vamos a comprobar si el nick elegido ya existe para evitar o permitir el registro
            if (isset($_POST['registrar'])) {
                $usuario = DB::getUser($_SESSION['id']);
                $partida = DB::getGameId($_SESSION['id_game']);
                $clase = $_POST['clase'];
                $playerName = $_POST['playerName'];
                if ($clase == "guerrera") {
                    $clase = 1;
                    $vida = 30;
                    DB::setUserGame($usuario->getId_user(), $partida->getId_game(), 0, $clase, 1, $vida, $playerName);
                    header("Location: partida.php");
                }
                else if ($clase == "ladron") {
                    $clase = 2;
                    $vida = 20;
                    DB::setUserGame($usuario->getId_user(), $partida->getId_game(), 0, $clase, 1, $vida, $playerName);
                    header("Location: partida.php");
                }
                else {
                    $clase = 3;
                    $vida = 15;
                    DB::setUserGame($usuario->getId_user(), $partida->getId_game(), 0, $clase, 1, $vida, $playerName);
                    header("Location: partida.php");
                }
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
        <div class="container">
            <div class="row">
                <div class="col">
                    
                    <h3>Crea tu personaje</h3>
                    <hr>
                    <br><br>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form method="post" class="centrar"> 
                    
                </div>
            </div>           
            <form method="post" class="centrar">
                <img src="media/LogoAquelarre.gif" class="rounded mx-auto d-block" alt="...">
                <br><br>
                <div class="form-group" >
                    <label for="playerName" >Nombre de personaje</label>
                    <input type="text"  class="form-control" id="playerName" aria-describedby="userHelp" name="playerName" placeholder="Pon un nombre a tu personaje" required>
                </div>
                <div class="form-group">
                    <label for="clase">Clase de personaje</label>
                    <select class="form-control" name="clase" id="clase" required>
                    <option value="guerrera">Guerrera</option>
                    <option value="ladron">Ladrón</option>
                    <option value="brujo">Brujo</option>
                    </select>
                </div>
                <div class="form-check" style="float: right;">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">¡Estoy listo para continuar!</label>
                </div>
                <br><br>
                <button type="submit" class="btn btn-primary" name="registrar" id="registrar" style="float: right;">Crear personaje</button>
            </form>
                
                
        </div>    
        </div>
    </body>
</html>