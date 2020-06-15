<?php

class User {
    protected $id_user;
    protected $nick;
    protected $pass;
    protected $about;
    protected $fecha;
    
    public function __construct($row) {
        $this->id_user = $row['id_user'];
        $this->nick = $row['nick'];
        $this->pass = $row['pass'];
        $this->about = $row['about'];
        $this->fecha = $row['fecha'];
    }
    
    public function getId_user() { return $this->id_user; }
    public function getNick() { return $this->nick; }
    public function getPass() { return $this->pass; }
    public function getAbout() { return $this->about; }
    public function getFecha() { return $this->fecha; }
}

?>