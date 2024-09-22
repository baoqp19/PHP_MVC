<?php

session_start();

spl_autoload_register(function ($class) {
    $fileName = "$class.php";

    $fileModel = PATH_MODEL . $fileName;
    $fileControllerClient = PATH_CONTROLLER_CLIENT . $fileName;
    $fileControllerAdmin = PATH_CONTROLLER_ADMIN . $fileName;


    if (is_readable($fileModel)) {
        require_once $fileModel;
    } else if (is_readable($fileControllerClient)) {
        require_once $fileControllerClient;
    } else if (is_readable($fileControllerAdmin)) {
        require_once $fileControllerAdmin;
    }
});








require_once './configs/env.php';
require_once './configs/helper.php';



// $product = new Product();
// // $data = $product->select('id, name', 'id > :id OR price > :price', ['id' => 3, 'price' => 36000]);
// // $data = $product->count();
// // $data = $product->paginate($_GET['page'] ?? 1);
// //  $data = $product->find('*', 'id = :id', ['id' => 2]);
// //  $data = $product->delete('id = :id', ['id' => 1]);
// // $data = $product->insert([
// //         'name' => "Name 4",
// //         'price' => 20000,
// // ]);

// $data = $product->update(
//     [
//         'name' => "Name 5",
//         'price' => 90000,
//     ],
//     'id = :id',
//     ['id' => 2]
// );

// debug($data);


$mode = $_GET['mode'] ?? 'client';

// client
if ($mode == 'admin') {
    require_once './routes/admin.php';
} else {
    require_once './routes/client.php';
}
