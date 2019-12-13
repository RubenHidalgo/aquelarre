<!-- Rubén Hidalgo González - Proyecto fin de ciclo -->


<?php
session_start();

//Añadimos al mensaje el nombre del usuario que lo escribe
$post_data = $_SESSION['id'].': '.$_POST['data']."\n"."\n";
if (!empty($post_data)) {

    //Definimos el nombre del fichero de log como el id del juego
    $handle = fopen("files/".$_SESSION['id_game'].".txt", "a");
    fwrite($handle, $post_data);
    fclose($handle);
}
?>