<?php

class UserGame {
    protected $id_user_game;
    protected $id_game;
    protected $id_user;
    protected $director;
    protected $clase;
    protected $vida;
    protected $nivel;
    protected $nombre;
    
    public function __construct($row) {
        $this->id_user_game = $row['id_user_game'];
        $this->id_game = $row['id_game'];
        $this->id_user = $row['id_user'];
        $this->director = $row['director'];
        $this->clase = $row['clase'];
        $this->vida = $row['vida'];
        $this->nivel = $row['nivel'];
        $this->nombre = $row['nombre'];
    }
    
    public function getId_user_game() { return $this->id_user_game; }
    public function getId_game() { return $this->id_game; }
    public function getId_user() { return $this->id_user; }
    public function getDirector() { return $this->director; }
    public function getClase() { return $this->clase; }
    public function getVida() { return $this->vida; }
    public function getNivel() { return $this->nivel; }
    public function getNombre() { return $this->nombre; }
}

?>