<?php if ($product): ?> 
<!-- Formulaire d'édition -->
<section>     
   <form action="" method="post">
       <input type="hidden" name="id" value="<?= $product->__get('id'); ?>">
       <input type="text" name="name" value="<?= $product->__get('name'); ?>">
       <input type="text" name="price" value="<?= $product->__get('price'); ?>">
       <input type="submit" value="Update" name="updateproduct">
   </form>
</section>
<?php endif; ?>
