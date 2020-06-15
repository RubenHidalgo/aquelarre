<?php

class Post {
    protected $id_post;
    protected $title;
    protected $picture;
    protected $body_text;
    protected $created;
    
    public function __construct($row) {
        $this->id_post = $row['id_post'];
        $this->title = $row['title'];
        $this->picture = $row['picture'];
        $this->body_text = $row['body_text'];
        $this->created = $row['created'];
        
    }
    
    public function getId_post() { return $this->id_post; }
    public function getTitle() { return $this->title; }
    public function getPicture() { return $this->picture; }
    public function getBody_text() { return $this->body_text; }
    public function getCreated() { return $this->created; }
    
}

?>