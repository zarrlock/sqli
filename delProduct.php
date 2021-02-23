<?php

require 'Product.php';

if (isset($_POST["id"])) {
    $id = htmlspecialchars($_POST["id"]);
    $db_con = new PDO('mysql:host=localhost;dbname=demo', 'root', '');
    $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db_con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    try {
        $querry = "DELETE FROM products WHERE pk = :id";
        $query_params = array(':id' => $id);
        $tmp = $db_con->prepare($querry);
        $results = $tmp->execute($query_params);
    } catch (PDOException $exception) {
        $err = true;
    }
}
header('Location: productList.php');
?>
