<?php

class User {
    protected $id_user;
    protected $nick;
    protected $pass;
    protected $about;
    
    public function __construct($row) {
        $this->id_user = $row['id_user'];
        $this->nick = $row['nick'];
        $this->pass = $row['pass'];
        $this->about = $row['about'];
    }
    
    public function getId_user() { return $this->id_user; }
    public function getNick() { return $this->nick; }
    public function getPass() { return $this->pass; }
    public function getAbout() { return $this->about; }
}

?>