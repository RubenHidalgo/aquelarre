<?php

class Log {
    protected $nick;
    protected $acceso;
    
    public function __construct($row) {
        $this->nick = $row['nick'];
        $this->acceso = $row['acceso'];
        
    }
    
    public function getNick() { return $this->nick; }
    public function getAcceso() { return $this->acceso; }
}

?>