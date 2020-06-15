<?php

class Game {
    protected $id_game;
    protected $nameg;
    protected $about;
    protected $created;
    
    public function __construct($row) {
        $this->id_game = $row['id_game'];
        $this->nameg = $row['nameg'];
        $this->about = $row['about'];
        $this->created = $row['created'];
        
    }
    
    public function getId_game() { return $this->id_game; }
    public function getNameg() { return $this->nameg; }
    public function getAbout() { return $this->about; }
    public function getCreated() { return $this->created; }
}

?>