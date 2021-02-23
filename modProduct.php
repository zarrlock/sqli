<?php

  foreach ($products as $pro) {
    if($pro -> __get("id") == $_POST['id']){
      $product = $pro;
    }
  }
  var_dump($product);

?>

<form action="" method="post">
    <label for="name">Nom : </label>
    <input type="hidden" name="id" value="<?= $product->__get('id'); ?>">
    <input type="text" id="name" name="name" value="<?= $product -> __get("name")?>">
    <label for="price">Prix : </label>
    <input type="number" id="price" name="price" value="<?= $product -> __get("price")?>">
    <input type="submit" name="updateProduct" value="Modifier Produit">
</form>
