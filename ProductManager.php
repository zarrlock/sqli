<?php 
include('models/entities/Product.php');
include('models/dao/ProductDAO.php');
include('controllers/ProductController.php');
$productController = new ProductController ();
var_dump($_POST);

if(isset($_POST) && isset($_POST['updateproduct'])) {
    $productController->update($_POST);
}

if(isset($_POST) && isset($_POST['createproduct'])) {
    $productController->store($_POST);
}

$productController->index();

if(isset($_POST) && isset($_POST['getproduct'])) {
    $productController->edit($_POST['id']);
}else {
    $productController->creat();
}

if(isset($_POST) && isset($_POST['deleteproduct'])) {
    $productController->delete($_POST);
}

$productController->show(2);
