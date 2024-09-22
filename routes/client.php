<?php

// require_once PATH_CONTROLLER_CLIENT . 'HomeController.php';
// require_once PATH_CONTROLLER_CLIENT . 'Home1Controller.php';

$action = $_GET['action'] ?? '/';

match ($action) {

    '/'          => (new HomeController)->index(),
    'test-show'  => (new Home1Controller)->show(),
};
