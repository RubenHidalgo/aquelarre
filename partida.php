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
       
        <?php
            session_start();
        ?>

        <script>

            //Función que va a cargar el texto del archivo en un div de la página
            $(document).ready(function(){
                var data = <?php echo json_encode('files/'.$_SESSION['id_game'].'.txt', JSON_HEX_TAG); ?>;
                $.get(data, function(data) {
                $('#log').text(data);
                }, 'text');
            });

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
                xmlhttp.open("POST","save.php",true);
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

            //Función para permitir al director hacer una tirada de dados de 1 a 100 aleatoria.
            function dice(){
                document.getElementById("tirada").innerHTML = Math.floor(Math.random() * 100) + 1;
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

        <?php
            $partida = DB::getGameID($_SESSION['id_game']);
            $jugadores = DB::getUsersGame($_SESSION['id_game']);
        ?>                    
        <div class="main">
            <div class="row">
                <div class="col-sm-8">
                    <a href="javascript: document.body.scrollIntoView(false);">Ve a los mensajes nuevos</a>
                    <br><br>
                    <div><pre id="log"></pre></div>
                </div>
                <div class="col-sm-4" id="columna-der">
                    
                    <!-- Cargamos los datos de la partida (nombre, director, jugadores) -->
                    <div id="mantener">
                    <p>Partida:</p>
                    <?php
                        echo '<h4>'.$partida->getNameg().'</h4>';
                    ?>
                    <br><br>
                    <p>Director de juego:</p>
                    <?php
                        //Aquí vamos a asignar a cada jugador una variable, directo, player1, etc
                        $director = DB::getUserId($jugadores[0]->getId_user());
                        echo '<h4>'.$director->getNick().'</h4>';
                    ?>
                    <br><br>
                    <p>Jugadores:</p>
                    <?php
                        $jugador1 = DB::getUserId($jugadores[1]->getId_user());
                        echo '<h4>'.$jugador1->getNick().'</h4>';
                    ?>
                    
                    <?php
                        $jugador2 = DB::getUserId($jugadores[2]->getId_user());
                        echo '<h4>'.$jugador2->getNick().'</h4>';
                    ?>
                    
                    <?php
                        $jugador3 = DB::getUserId($jugadores[3]->getId_user());
                        echo '<h4>'.$jugador3->getNick().'</h4>';
                    ?>
                    <hr>
                    
                    <!-- Enviamos el mensaje a la función save() -->
                    <textarea id="data" placeholder="Escribe tu mensaje"></textarea><br><br>
                    <button id="save" onclick="save();return false;">Enviar</button>
                    <?php
                        //Si el usuario logueado es el director, cargamos sus herramientas propias
                        if ($_SESSION['id'] == $director->getNick()) {
                            echo '<br><br><br><div id="mantener" style="font-style: italic">Herramientas del director';
                            echo '<br><br><button id="dice" onclick="dice();return false;">Tira los dados</button>';
                            echo '<br><br><p id="tirada"></p>';
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>