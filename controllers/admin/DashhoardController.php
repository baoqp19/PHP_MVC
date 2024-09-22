<?php 
//  http://localhost/MVC/?action=test-show&id=5
    class DashhoardController{
        public function index(){
            $view = 'dashboard';
            require_once PATH_VIEW_ADMIN_MAIN;
        }
    }

?>