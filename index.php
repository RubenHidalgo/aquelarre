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
            
            if (!isset($_GET['userdeleted'])) {
                session_start();
            }

            
            
            //Si el usuario se desloguea, liberamos la variable de sesión y mostramos el menú de login mediante $showLogin 
            if (isset($_POST['logout']) || (!isset($_SESSION['id']))) {
                unset($_SESSION['id']);
                $showLogin = true;
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
        <?php                
        
        ?>            
        <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <h1 class="titulo">AQUELARRE</h1>
                <div class="caja-subtitulo"><p class="subtitulo">El juego de rol demoníaco medieval</p></div>
                <p>
					<a class="btn btn-primary btn-lg" href="">SABER MÁS</a>
				</p>
            </div>
            </div>
        </div>
        </header>
        
        <div class="main">
            <br><br>
            <div class="container" style="max-width: 900px;">     
                <?php
                        if (isset($_GET['userdeleted'])) {
                        
                            unset($_SESSION['id']);
                            $delUsuario = DB::getUserId($_GET['userdeleted']);
                            
                            $delGames = DB::getGamesDirector($delUsuario->getId_user());
                            DB::delUserGame($delUsuario->getId_user());
                            foreach ($delGames as $delGame) {
                                DB::delGameUser($delGame->getId_game());
                            }
                            foreach ($delGames as $delGame) {
                                DB::delGame($delGame->getId_game());
                            }
                            DB::delUser($delUsuario->getNick());
                            echo '<div class="alert alert-success" role="alert">Tu cuenta se ha borrado con éxito.</div>';
                        }
                        
                        $posts = DB::getPosts();

                        foreach ($posts as $post) {
                            echo '<div class="row">';
                                echo '<h2>'.$post->getTitle().'</h2>';
                            echo '</div>';
                            echo '<div class="row">';
                                echo '<p>Publicado el '.date("d/m/Y, H:i:s.", strtotime($post->getCreated())).'<p>';
                            echo '</div>';
                            echo '<div class="row">';
                                echo '<img src="'.$post->getPicture().'" class="img-fluid" style="margin: 0 auto;">';
                            echo '</div>';
                            echo '<br><br>';
                            echo '<div class="row">';
                                echo '<p style="text-align: justify;">'.nl2br($post->getBody_text()).'<p><br><br>';
                            echo '</div>';
                        }
                ?>
            </div>
        </div>
    </body>
</html>