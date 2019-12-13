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

        <script type='text/javascript'>

            //Función para mostrar u ocultar los formularios al hacer click en los botones
            $(document).ready(function(){
                $("#cambio-nick").hide();
                $("#cambio-pass").hide();
                $("#cambio-about").hide();

                $("#boton-pass").click(function(){
                    $("#cambio-pass").show();
                    $("#cambio-nick").hide();
                    $("#cambio-about").hide();
                });

                $("#boton-nick").click(function(){
                    $("#cambio-pass").hide();
                    $("#cambio-nick").show();
                    $("#cambio-about").hide();
                });

                $("#boton-about").click(function(){
                    $("#cambio-pass").hide();
                    $("#cambio-nick").hide();
                    $("#cambio-about").show();
                });
            });

            //Función para comprobar que los campos coinciden al cambiar el password
            $(function () {
                $('#new-repeat').keyup(function () {
                    if ($(this).val() === $('#new').val()) {
                        $('#nocoincide').text('');
                        $('#cambiar-pass').prop('disabled', false);
                    } 
                    else {
                        $('#nocoincide').text('Las contraseñas no coinciden.');
                        $('#cambiar-pass').prop('disabled', true);
                    }
                });
            });
        </script>

    </head>
    <body>
        <?php
            require_once 'clases/DB.php';
            
            session_start();

            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                header("Location: index.php");
            }

            if (isset($_POST['login'])) {
                $usuario = DB::getUser($_POST['user']);
                if (count($usuario)==1) {
                    if ($usuario->getPass() == $_POST['password']) {
                        $showLogin = false;
                        $_SESSION['id'] = $usuario->getNick();
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

            //Cargamos el objeto de tipo User logueado
            $usuario = DB::getUser($_SESSION['id']);

            //Para cambiar el nick comprobamos primero que no exista en la BBDD
            if (isset($_POST['cambiar-nick'])) {
                $existe = false;
                $usuarios = DB::getUsers();

                foreach ($usuarios as $user) {
                    if ($user->getNick() == $_POST['nick']) {
                        $existe = true;
                    }
                }

                if ($existe) {
                    echo '<script type="text/javascript">alert("El nick elegido ya está siendo utilizado!");</script>';
                }
                else {
                    DB::setNick($_SESSION['id'], $_POST['nick']);
                    $_SESSION['id'] = $_POST['nick'];
                    $usuario = DB::getUser($_POST['nick']);
                }
            }

            //Cambiamos el password comprobando que ha introducido su password correctamente antes
            if (isset($_POST['cambiar-pass'])) {
                
                if ($usuario->getPass() != $_POST['old']) {
                    echo '<script type="text/javascript">alert("El password no es correcto");</script>';
                }
                else {
                    DB::setPass($usuario->getNick(), $_POST['new']);
                }
            }

            //Cambiamos la descripción del usuario, se comprueba que no esté en blanco.
            if (isset($_POST['cambiar-about'])) {
                
                if ($_POST['about'] === '') {
                    echo '<script type="text/javascript">alert("No dejes la descripción en blanco");</script>';
                }
                else {
                    DB::setAbout($usuario->getNick(), $_POST['about']);
                    $usuario = DB::getUser($_SESSION['id']);
                }
            }

            $partidas = DB::getGamesUser($usuario->getId_user());
        ?> 
        <nav class="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="jugar.php">Jugar</a></li>
                <li><a href="cuenta.php">Mi cuenta</a></li>
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

                    <!-- Formularios para el cambio de datos que se mostrarán u ocultarán al hacer click el usuario -->
                    <h2>Mis datos</h2>
                    <p>Usuario: <?php echo $usuario->getNick() ?></p>
                    <p>Sobre mí: <?php echo $usuario->getAbout() ?></p>
                    <p>Actualmente participando en <?php echo count($partidas); ?> partidas</p>
                    <p><button type="button" id="boton-nick">Cambiar nick</button>
                       <button type="button" id="boton-pass">Cambiar contraseña</button>
                       <button type="button" id="boton-about">Cambiar sobre mí</button></p>
                    <div id="cambio-nick">
                        <form method="POST">
                            <label for="nick"><b>Nuevo nick</b></label>
                            <input type="text" name="nick" required>
                            <br><br>
                            <button type="submit" name="cambiar-nick">Cambiar</button>
                        </form>
                    </div>
                    <div id="cambio-pass">
                        <form method="POST">
                            <label for="old"><b>Contraseña actual</b></label>
                            <input type="password" name="old" required>
                            <br><br>
                            <label for="new"><b>Contraseña nueva</b></label>
                            <input type="password" name="new" id="new" required>
                            <br><br>
                            <label for="new-repeat"><b>Repite contraseña</b></label>
                            <input type="password" name="new-repeat" id="new-repeat" required>
                            <br><br>
                            <button type="submit" name="cambiar-pass" id="cambiar-pass" disabled='disabled'>Cambiar</button>
                            <p id="nocoincide"></p>
                        </form>
                    </div>
                    <div id="cambio-about">
                        <form method="POST">
                            <label for="about"><b>Nuevo Sobre mí</b></label>
                            <input type="text" name="about" required>
                            <br><br>
                            <button type="submit" name="cambiar-about">Cambiar</button>
                        </form>
                    </div>
                    <p></p>
                
            </div>
        </div>
    </body>
</html>