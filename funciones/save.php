<!-- Rubén Hidalgo González - Proyecto fin de ciclo -->


<?php
session_start();

//Añadimos al mensaje el nombre del usuario que lo escribe
$post_data = "\n"."\n".$_SESSION['player'].': '.$_POST['data'];
if (!empty($post_data)) {

    //Definimos el nombre del fichero de log como el id del juego
    $handle = fopen("../files/".$_SESSION['id_game'].".txt", "a");
    fwrite($handle, $post_data);
    fclose($handle);
}
?>