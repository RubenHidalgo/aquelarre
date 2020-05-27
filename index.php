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
            
            //Si el usuario se desloguea, liberamos la variable de sesión y mostramos el menú de login mediante $showLogin 
            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                $showLogin = true;
            }

            //Cuando el usuario se loguea, recuperamos sus datos y comprobamos que el password es correcto.
            if (isset($_POST['login'])) {
                $usuario = DB::getUser($_POST['user']);
                if (count($usuario)==1) {
                    if ($usuario->getPass() == $_POST['password']) {
                        $showLogin = false;
                        //Creamos la variable de sesión con el nick.
                        $_SESSION['id'] = $usuario->getNick();
                        header("Location: index.php");
                    }
                    else {
                        $showLogin = true;
                    }
                }
                //Si el usuario no existe, lo mandamos a la página de registro.
                else {
                    $showLogin = true;
                    header("Location: registro.php");
                }
            }
        ?> 
        <nav class="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php
                    //Si no hay usuario logueado, no cargamos las secciones del menú
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
                                echo "<li><input type='password' name='password' placeholder='Contraseña'></li>";
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
            <?php
                if (!isset($_SESSION['id'])) {
                    echo '<div style="text-align: center;"><h4>¿Aún no tienes una cuenta?</h4>';
                    echo '<p style="text-align: center; font-style: bold">¡Ya somos ';
                    $usuarios = DB::getUsers();
                    echo count($usuarios);
                    echo ' usuarios registrados!<br><br>';
                    $partidas = DB::getGames();
                    echo 'Tenemos '.count($partidas)." partidas en marcha. ¡Regístrate y juega!</p></div>";
                }
                else {
                    echo '<div style="text-align: center;"><h4>Bienvenido, '.$_SESSION['id'].'.</h4>';
                    echo '<p style="text-align: center; font-style: bold">Accede a las partidas o a tu cuenta usando el menú superior.</p></div> ';
                }
            ?>
        </div>
    </body>
</html>