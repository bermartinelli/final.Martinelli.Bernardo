<?php


class apiModel {
    private $db;

    public function __construct() {
        $this-> db -> new PDO('mysql:host=localhost;' . 'db_name=db_jobs;charset=uft8', 'root', '');
    }

    public function getAllPosts() {
        $query = $this-> db> prepare('SELECT * FROM PUBLICACION');
        $query -> execute();
        $posts = $query-> fetchAll(PDO::FETCH_OBJ);

        return $posts;
    }

}