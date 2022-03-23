<?php

require_once'api.model.php';
require_once'api.view.php';

class apiController{
    private $apiModel;
    private $apiView;

    public function __construct() {
        $this-> apimodel -> new apiModel();
        $this-> apiView -> new apiView();
    }

    public function getPosts($params=NULL) {
        $posts = $this-> apiModel -> getAllPosts();

        if($posts) {
        $this-> apiView -> response ($posts, 200); //le envio a la vista todos los post y la respuesta 200 de que fue satisfactoria la consulta.
        } else {
            $this-> apiView -> response ('No se pudieron obtener las publicaciones' , 404);
        }
    
    }
}