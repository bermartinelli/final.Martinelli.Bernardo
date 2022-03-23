/* 
a. Como usuario quiero poder ver una publicación determinada. La publicación deberá mostrar, además de sus datos, los detalles 
de la categoría y los datos del profesional asociado. Se debe registrar la visita a la publicación. 

b. Como usuario quiero poder ingresar una nueva publicación al sistema. El usuario no puede tener más de 5 publicaciones activas 
a menos que sea premium.

c. Como usuario quiero poder listar todas las publicaciones que coincidan con un criterio de búsqueda. La búsqueda puede realizarse 
por categoría y/o descripción.

d. Como administrador quiero desactivar una publicación. La publicación solo se podrá desactivar si: 
no pertenece a una categoría destacada
el usuario no es premium


Además, se detectó la necesidad de que la plataforma ofrezca el siguiente Servicios Web:
Obtener la lista de publicaciones del portal. 

*/

<?php

include_once 'view.php';
include_once 'model.php';
include_once 'authHelper.php';

class empleosController {
    private $view;
    private $model;
    private $authHelper;

    public function __construct() {
        $this->view = new empleosView();
        $this-> model = new empleosModel();
        $this-> authHelper = new authHelper();
    }

    public function showPost($id_post) {

        $this->authHelper-> checkUserLoggedIn();
        
        $post = $this-> model-> getPostData($id_post);

        if ($post) {
            $id_user = $post-> id_user;
            $id_categoria = $post -> id_categoria;
            $actualDate = //alguna funcion que retorne la fecha de ese dia
            

            $catDetails = $this-> model -> getCatDetails($id_categoria);
            $userData = $this-> model-> getUserData($id_user);
            $this-> view -> showPostData($post, $catDetails, $userData);

            $this-> model-> newVisit($actualDate, $id_post, $id_user);
        } else {
            $this-> view -> showPostError('Error. La publicacion solicitada no se encuentra disponible.');
        }    

    }

    public function newPost() {
        $this->authHelper-> checkUserLoggedIn();

        if(!empty($_POST['date']) && !empty($_POST['activa']) && !empty($_POST['descripcion']) && !empty($_POST['id_categoria'])) {
            $postDate = $_POST['date']; //o la traigo desde el post o tmb con alguna funcion que me devuelva la fecha actual
            $isActive = $_POST['activa'];
            $description = $_POST['descripcion'];
            $id_user = $_SESSION['USER_ID'];
            $id_categoria = $_POST['id_categoria'];

            $nActivePosts = $this-> model -> countActivePosts($id_user);
            $userData = $this-> model-> getUserData($id_user);
            $isPremium = $userData-> premium;
            $numberPost = $nActivePosts -> numero;

            if ($numberPost < 5 || ($numberPost > 4 && $isPremium == true)) {
                $this->model-> newPost($postDate, $isActive, $description, $id_user, $id_categoria);
                header("Location: " . BASE_URL); //una vez hecha la entrada redirecciono al inicio

            } else {
                $this->model-> newPost($postDate, false, $description, $id_user, $id_categoria);
                header("Location: " . BASE_URL); 
            } //si no se cumplen las condiciones, se carga la publicacion pero como no activa.
        
        } else {
            $this-> view-> showPostError('Por favor complete todos los campos solicitados.');
        }
    }

    public function deactivatePost($id_post) {

        $this->authHelper-> checkAdminLoggedIn(); //a la hora de haber iniciado sesion.

        $post = $this-> model-> getPostData($id_post);
        $id_categoria = $post-> id_categoria;
        $id_user = $post -> id_user;

        $categoriaData = $this-> model-> infoCategoria($id_categoria);
        $esDestacada = $categoriaData -> destacada;

        $userData = $this-> model-> getUserData($id_user);
        $isPremium = $userData-> premium;

        if ($isPremium == false && $esDestacada == false) {
            $this-> model -> deactivatePost($id_post);


        } else {
            $this-> view-> showError('No se pudo desactivar la publicacion. Chequear condiciones.');
        }




    }
}

