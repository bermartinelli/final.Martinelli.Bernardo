<?php

 class AuthHelper {
     function __construct() {
         if (session_status() != PHP_SESSION_ACTIVE) {
             session_start();
         }
     }

     public function checkUserLoggedIn() {
         if(empty($_SESSION['USER_ID'])) {
             header("Location: " . BASE_URL); //configurando en el router el BASE_URL como la pagina inicial.
         }
     }

     public function checkAdminLoggedIn() {
        if(empty($_SESSION['ADMIN_ID'])) {
            header("Location: " . BASE_URL); //configurando en el router el BASE_URL como la pagina inicial.
        }
    }
 }