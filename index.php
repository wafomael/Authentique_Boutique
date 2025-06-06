<?php
   include "librairie/fonction.lib.php";

   $pdo = Connect();

   include "inclus/entete.inc";
   ?>
<?php
   PrintColectionAlaUne($pdo);
?>

<!-- Section Produits -->
<section class="py-5">
   <div class="container">
      <h2 class="fw-bold mb-4">Nos Produits Populaires</h2>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
         <?php
            PrintProduitAlaUne($pdo);
            ?>
      </div>
   </div>
</section>

<?php
   include "inclus/piedPage.inc"
   ?>