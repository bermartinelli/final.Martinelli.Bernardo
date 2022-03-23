<?php

class empleosModel {
    private $db;

    public function __construct() {
        $this-> db -> new PDO('mysql:host=localhost;' . 'db_name=db_jobs;charset=uft8', 'root', '');
    }

    function getPostData($id_post){
        $query = $this-> db> prepare('SELECT * FROM PUBLICACION WHERE id= ?');
        $query -> execute([$id_post]);
        $post = $query-> fetch(PDO::FETCH_OBJ);

        return $post;
    }

    function getCatDetails($id_categoria) {
        $query = $this-> db> prepare('SELECT * FROM CATEGORIA WHERE id= ?');
        $query -> execute([$id_categoria]);
        $catDetails = $query-> fetch(PDO::FETCH_OBJ);

        return $catDetails;
    }

    function getUserData($id_user){
        $query = $this-> db> prepare('SELECT email, telefono, premium FROM USER WHERE id= ?');
        $query -> execute([$id_user]);
        $userData = $query-> fetch(PDO::FETCH_OBJ);

        return $userData;
    }

    function newVisit($actualDate, $id_post, $id_user) {
        $query = $this-> db> prepare('INSERT INTO VISIT (fecha, id_publicacion, id_user) VALUES(?,?,?))');
        $query -> execute([$actualDate, $id_post, $id_user]);
    }

    function countActivePosts($id_user) {
        $query = $this-> db> prepare('SELECT COUNT(*) AS numero FROM PUBLICACION WHERE activa = true AND id_user= ?');
        $query -> execute([$id_user]);
        return $query-> fetch(PDO::FETCH_OBJ);
    }

    function newPost($postDate, $isActive, $description, $id_user, $id_categoria) {
        $query = $this-> db> prepare('INSERT INTO PUBLICACION (fecha, activa, descripcion, id_user, id_categoria) VALUES(?,?,?,?,?))');
        $query -> execute([$postDate, $isActive, $description, $id_user, $id_categoria]);
    }

    function infoCategoria($id_categoria) {
        $query = $this-> db> prepare('SELECT * FROM CATEGORIA WHERE id= ?');
        $query -> execute([$id_categoria]);
        $categoriaData = $query-> fetch(PDO::FETCH_OBJ);

        return $categoriaData;
    }

    function deactivatePost($id_post) {
        $query = $this-> db> prepare('UPDATE PUBLICACION SET activa = false WHERE id= ?');
        $query -> execute([$id_post]);
    }
}