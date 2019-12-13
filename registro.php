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
            $(function () {
                $('#psw-repeat').keyup(function () {
                    if ($(this).val() === $('#psw').val()) {
                        $('#activar').prop('disabled', false);
                        $('#nocoincide').hide();
                    } 
                    else {
                        $('#nocoincide').text('Las contraseñas no coinciden.');
                        $('#activar').prop('disabled', true);
                    }
                });
            }); 
        </script>

        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    
        <?php
            require_once 'clases/DB.php';
            
            session_start();
            
            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                $showLogin = true;
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

            if (isset($_POST['registrar'])) {
                $existe = false;
                $usuarios = DB::getUsers();

                foreach ($usuarios as $user) {
                    if ($user->getNick() == $_POST['usuario']) {
                        $existe = true;
                    }
                }
                
                if (!$existe) {
                    DB::setUser($_POST['usuario'], $_POST['psw'], $_POST['about']);
                    $_SESSION['id'] = $_POST['usuario'];
                    header("Location: index.php");
                }
            }
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
            if ($existe) {
                echo "<p class='error'>El nombre de usuario ya existe. Prueba con otro.</p>";
            }
            ?>
            <form method="post">
                <div class="container">
                    <h1>Registro</h1>
                    <p>Regístrate para empezar a jugar (campos obligatorios).</p>
                    <hr>
                    <label for="usuario"><b>Usuario</b></label>
                    <input type="text" placeholder="Nombre de usuario" name="usuario" required>
                    <br><br>
                    <label for="psw"><b>Contraseña</b></label>
                    <input type="password" placeholder="Contraseña" name="psw" id="psw" required>
                    <br><br>
                    <label for="psw-repeat"><b>Repite contraseña</b></label>
                    <input type="password" placeholder="Repite contraseña" name="psw-repeat" id="psw-repeat" required>
                    <p id="nocoincide"></p>
                    <br><br>
                    <label for="about"><b>Háblanos sobre ti</b></label>
                    <input type="text" placeholder="Cuéntanos qué tipo de jugador eres" name="about" required>
                    <br><br>
                    <button type="submit" name="registrar" id="activar" disabled='disabled'>Registro</button>
                </div>
            </form>
            
        </div>
    </body>
</html>