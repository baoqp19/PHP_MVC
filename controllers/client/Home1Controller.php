<?php 
//  http://localhost/MVC/?action=test-show&id=5
    class Home1Controller{
        public function show(){
            echo 'Đây là trang test CLIENT có ID = ' . $_GET['id'];
        }
    }

?>