<?php if (!empty($products)): ?> 
   <section>
    <table>
       <?php foreach ($products as $product): ?>
           <tr>
               <td><?= $product->__get('id'); ?></td>
               <td><?= $product->__get('name'); ?></td>
               <td><?= $product->__get('price'); ?></td>
               <td>
                   <form action="" method="post">
                       <input type="hidden" name="id" value="<?= $product->__get('id'); ?>">
                       <input type="submit" value="Modifier" name="getproduct">
                   </form>
               </td>
               <td>
                   <form action="" method="post">
                       <input type="hidden" name="id" value="<?= $product->__get('id'); ?>">
                       <input type="submit" value="Supprimer" name="deleteproduct">
                   </form>
               </td>
           </tr>
       <?php endforeach; ?>  
    </table>
</section>
<?php endif; ?>
