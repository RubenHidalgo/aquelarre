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
        
        <script type='text/javascript'>

            //Mediante esta función vamos a controlar si los dos campos de password no coinciden
            //En ese caso, desactivamos el botón de registro
            $(function () {
                $('#psw-repeat').keyup(function () {
                    if ($(this).val() === $('#psw').val()) {
                        $('#activar').prop('disabled', false);
                        $('#nocoincide').hide();
                    } 
                    else {
                        $('#nocoincide').show();
                        $('#activar').prop('disabled', true);
                    }
                });
            }); 
            $(function () {
                $('#psw').keyup(function () {
                    if ($(this).val() === $('#psw-repeat').val()) {
                        $('#activar').prop('disabled', false);
                        $('#nocoincide').hide();
                    } 
                    else {
                        $('#nocoincide').show();
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

            //Si pulsamos el botón de registro, vamos a comprobar si el nick elegido ya existe para evitar o permitir el registro
            if (isset($_POST['registrar'])) {
                $existe = false;
                $usuarios = DB::getUsers();

                foreach ($usuarios as $user) {
                    if ($user->getNick() == $_POST['usuario']) {
                        $existe = true;
                    }
                }
                
                if (!$existe) {
                    $nickuser = mb_strtolower($_POST['usuario'], 'UTF-8'); 
                    DB::setUser($nickuser, $_POST['psw'], $_POST['about']);
                    $_SESSION['id'] = $nickuser;
                    DB::setLog($nickuser);
                    header("Location: index.php");
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

            <form method="post" class="centrar">
                <img src="media/LogoAquelarre.gif" class="rounded mx-auto d-block" alt="...">
                <br><br>
                <div class="alert alert-danger" id="nocoincide">
                    <p>Las contraseñas no coinciden</p>
                </div>
                <h1>Formulario de registro</h1>
                <p>Regístrate para empezar a jugar</p>
                <hr>
                <div class="form-group" >
                    <label for="userName" >Nombre de usuario</label>
                    <input type="text"  class="form-control" id="userName" aria-describedby="userHelp" name="usuario" placeholder="Introduce tu nombre de usuario" required>
                </div>
                <div class="form-group">
                    <label for="psw">Contraseña</label>
                    <input type="password" class="form-control" id="psw" aria-describedby="passwordHelp" name="psw" placeholder="Introduce tu contraseña" required>
                </div>
                <div class="form-group">
                    <label for="psw-repeat">Contraseña</label>
                    <input type="password" class="form-control" id="psw-repeat" aria-describedby="passwordHelp" name="psw-repeat" placeholder="Repite tu contraseña" required>
                </div>
                <div class="form-group">
                    <label for="about">Descripción</label>
                    <textarea type="text" class="form-control" id="about"  name="about" placeholder="Cuenta algo de ti (máximo 300 caracteres)" maxlength="300" rows="4" required></textarea>
                </div>
                <div class="form-check" style="float: right;">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">Acepto los términos de uso</label>
                </div>
                <br><br>
                <button type="submit" class="btn btn-primary" name="registrar" id="activar" disabled='disabled' style="float: right;">Registrarse</button>
            </form>
            
        </div>
    </body>
</html>