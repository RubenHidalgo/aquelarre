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
       
        <?php
            session_start();
        ?>

        <script>

            //Función que va a cargar el texto del archivo en un div de la página
            setInterval(function(){ 
                $(document).ready(function(){
                var data = <?php echo json_encode('files/'.$_SESSION['id_game'].'.txt', JSON_HEX_TAG); ?>;
                $.get(data, function(data) {
                $('#log').text(data);
                }, 'text');
                var pre = jQuery("#log");
                pre.scrollTop( pre.prop("scrollHeight") );
            });
            }, 1000);
            
            

            //Con está función vamos a recoger el texto del elemento con id data, para después enviarselo a save.php, que se encargará
            //de guardarlo en el archivo correspondiente
            function save(){
                var response=document.getElementById("response");
                var data = 'data='+document.getElementById("data").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    
                }
                }
                xmlhttp.open("POST","funciones/save.php",true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send(data);

                $('#data').val('');

                //Además, cargamos el fichero actualizado en la ventana
                var data = <?php echo json_encode('files/'.$_SESSION['id_game'].'.txt', JSON_HEX_TAG); ?>;
                $.get(data, function(data) {
                $('#log').text(data);
                }, 'text');
               
                //y hacemos scroll al final de la página
                window.scrollTo(0,document.body.scrollHeight);
            }

            function save100(){
                var response=document.getElementById("response");
                var data100 = 'data100='+Math.floor((Math.random() * 100) + 1);;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    
                }
                }
                xmlhttp.open("POST","funciones/save100.php",true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send(data100);

                $('#data100').val('');

                //Además, cargamos el fichero actualizado en la ventana
                var data = <?php echo json_encode('files/'.$_SESSION['id_game'].'.txt', JSON_HEX_TAG); ?>;
                $.get(data, function(data) {
                $('#log').text(data);
                }, 'text');
               
                //y hacemos scroll al final de la página
                window.scrollTo(0,document.body.scrollHeight);
            }

            function save10(){
                var response=document.getElementById("response");
                var data10 = 'data10='+Math.floor((Math.random() * 10) + 1);;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    
                }
                }
                xmlhttp.open("POST","funciones/save10.php",true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send(data10);

                $('#data10').val('');

                //Además, cargamos el fichero actualizado en la ventana
                var data = <?php echo json_encode('files/'.$_SESSION['id_game'].'.txt', JSON_HEX_TAG); ?>;
                $.get(data, function(data) {
                $('#log').text(data);
                }, 'text');
               
                //y hacemos scroll al final de la página
                window.scrollTo(0,document.body.scrollHeight);
            }
            
            function editUser() {
                document.getElementById('editUser').style.display = "block";
            }

            </script>
    
    </head>
    <body>
        <?php
            require_once 'clases/DB.php';
            
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

        <?php
            
            $partida = DB::getGameID($_SESSION['id_game']);
            $jugadores = DB::getUsersGame($_SESSION['id_game']);
            if (isset($_POST['subenivel'])) {
                foreach ($jugadores as $jugador) {
                if($jugador->getId_user_game() == $_POST['subenivel']) {
                    $nivelnuevo = $jugador->getNivel()+1;
                    DB::setNivel($nivelnuevo, $_POST['subenivel']);
                }
            }
            }
            $userLogged = DB::getUser($_SESSION['id']);
            foreach ($jugadores as $jugador) {
                if($jugador->getId_user() == $userLogged->getId_user()) {
                    $_SESSION['player'] = $jugador->getNombre(); 
                }
                
            }
            $nPlayers = count($jugadores);

            
        ?>                    
        <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <?php
                        echo '<h4>'.$partida->getNameg().'</h4>';
                    ?>
                    <hr>    
                    <br>
                    <div style="background-color: white;"><pre style="max-height: 600px;" id="log"></pre></div>
                    <div class="container" style="max-height: 600px;">
                        <div class="row">
                            <textarea class="form-control" style="width: 700px;" id="data" placeholder="Escribe tu mensaje"></textarea>
                            <button id="save" style="float: right; margin-top: 10px" class = "btn btn-primary float-right" onclick="save();return false;">Enviar</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    
                    <!-- Cargamos los datos de la partida (nombre, director, jugadores) -->
                    
                    
                    <?php
                        //Aquí vamos a asignar a cada jugador una variable, director, player1, etc
                        foreach ($jugadores as $jugador) {
                            if ($jugador->getDirector()==1) {
                                $director = DB::getUserId($jugador->getId_user());
                                if ($_SESSION['id'] != $director->getNick()) {
                                echo    '<p>Director de juego:</p>';
                                echo '<h4>'.$director->getNick().'</h4>';
                                echo '<br>';
                                echo '<p>Jugadores:</p>';
                                }
                            }
                        }
                    ?>
                    
                    <?php
                        foreach ($jugadores as $jugador) {
                            if ($jugador->getDirector()==0) {
                                if ($jugador->getNombre() == $_SESSION['player']) {
                                    echo '<h4 style="color: #D9230F;">'.$jugador->getNombre().'</h4>';
                                }
                                else {
                                    echo '<h4 style="color: #D9230F;">'.$jugador->getNombre().'</h4>';
                                    if ($_SESSION['id'] == $director->getNick()) {
                                        if ($jugador->getClase() == 1) {
                                            $fuerza = 50;
                                            $mente = 20;
                                            $agilidad = 35;
                                            $vida = $jugador->getVida();
                                            
                                            echo '<p style="font-style: italic;">Guerrera, nivel '.$jugador->getNivel().'</p>';
                                            echo '<form method = "POST">';
                                            echo '<input type="hidden" name="subenivel" value="'.$jugador->getId_user_game().'"></input>';
                                            echo '<p><button class="btn btn-secondary" >SUBIR DE NIVEL</button></p>';
                                            echo '</form>';
                                            echo '<p>Vida: '.$jugador->getVida().'</p>';
                                            echo '<p>Fuerza: '.$fuerza.'</p>';
                                            echo '<p>Mente: '.$mente.'</p>';
                                            echo '<p>Agilidad: '.$agilidad.'</p>';
            
                                        }
                                        else if ($jugador->getClase() == 2) {
                                            $fuerza = 30;
                                            $mente = 30;
                                            $agilidad = 50;
                                            $vida = $jugador->getVida();
                                            echo '<p style="font-style: italic;">Ladrón, nivel '.$jugador->getNivel().'</p>';
                                            echo '<form method = "POST">';
                                            echo '<input type="hidden" name="subenivel" value="'.$jugador->getId_user_game().'"></input>';
                                            echo '<p><button class="btn btn-secondary" >SUBIR DE NIVEL</button></p>';
                                            echo '</form>';
                                            echo '<p>Vida: '.$jugador->getVida().'</p>';
                                            echo '<p>Fuerza: '.$fuerza.'</p>';
                                            echo '<p>Mente: '.$mente.'</p>';
                                            echo '<p>Agilidad: '.$agilidad.'</p>';
                                        }
                                        else {
                                            $fuerza = 20;
                                            $mente = 60;
                                            $agilidad = 25;
                                            $vida = $jugador->getVida();
                                            echo '<p style="font-style: italic;">Brujo, nivel '.$jugador->getNivel().'</p>';
                                            echo '<form method = "POST">';
                                            echo '<input type="hidden" name="subenivel" value="'.$jugador->getId_user_game().'"></input>';
                                            echo '<p><button class="btn btn-secondary" >SUBIR DE NIVEL</button></p>';
                                            echo '</form>';
                                            echo '<p>Vida: '.$jugador->getVida().'</p>';
                                            echo '<p>Fuerza: '.$fuerza.'</p>';
                                            echo '<p>Mente: '.$mente.'</p>';
                                            echo '<p>Agilidad: '.$agilidad.'</p>';
                                        }
                                    }
                                }
                                
                            }
                            
                        }
                    ?>
                    
                    <hr>
                    
                    <?php
                        //Si el usuario logueado es el director, cargamos sus herramientas propias
                        if ($_SESSION['id'] == $director->getNick()) {

                            echo '<div style="font-style: italic">DADOS';
                            echo '<br><br><button class="btn btn-secondary" id="dice100" onclick="save100();return false;">DADO 1D100</button>';
                            echo '<br><br><button class="btn btn-secondary" id="dice10" onclick="save10();return false;">DADO 1D10</button>';
                            echo '<br><br>';
                            echo '</div>';
                        }
                        else {
                            echo '<div style="background-color: #FFD8D7; padding-left: 5%;">';
                            echo '<p style="font-style: italic;">Ficha de personaje</p>';
                            foreach ($jugadores as $jugador) {
                                if ($jugador->getNombre() == $_SESSION['player']) {
                                    $playerActive = DB::getUserNombre($_SESSION['player']);
                                }
                            }

                            if ($playerActive->getClase() == 1) {
                                $fuerza = 50;
                                $mente = 20;
                                $agilidad = 35;
                                $vida = $playerActive->getVida();
                                echo '<p>Guerrera, nivel '.$playerActive->getNivel().'</p>';
                                echo '<p>Vida: '.$playerActive->getVida().'</p>';
                                echo '<p>Fuerza: '.$fuerza.'</p>';
                                echo '<p>Mente: '.$mente.'</p>';
                                echo '<p>Agilidad: '.$agilidad.'</p>';

                            }
                            else if ($playerActive->getClase() == 2) {
                                $fuerza = 30;
                                $mente = 30;
                                $agilidad = 50;
                                $vida = $playerActive->getVida();
                                echo '<p>Ladrón, nivel '.$playerActive->getNivel().'</p>';
                                echo '<p>Vida: '.$playerActive->getVida().'</p>';
                                echo '<p>Fuerza: '.$fuerza.'</p>';
                                echo '<p>Mente: '.$mente.'</p>';
                                echo '<p>Agilidad: '.$agilidad.'</p>';
                            }
                            else {
                                $fuerza = 20;
                                $mente = 60;
                                $agilidad = 25;
                                $vida = $playerActive->getVida();
                                echo '<p>Brujo, nivel '.$playerActive->getNivel().'</p>';
                                echo '<p>Vida: '.$playerActive->getVida().'</p>';
                                echo '<p>Fuerza: '.$fuerza.'</p>';
                                echo '<p>Mente: '.$mente.'</p>';
                                echo '<p>Agilidad: '.$agilidad.'</p>';
                            }

                            echo '<br><br><br><div style="font-style: italic">DADOS';
                            echo '<br><br><button class="btn btn-secondary" id="dice100" onclick="save100();return false;">DADO 1D100</button>';
                            echo '<br><br><button class="btn btn-secondary" id="dice10" onclick="save10();return false;">DADO 1D10</button>';
                            echo '<br><br>';
                            echo '</div>';
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>    
        </div>
    </body>
</html>