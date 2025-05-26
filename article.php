<?php
    include "librairie/fonction.lib.php";

    $pdo = Connect();


    include "inclus/entete.inc";
?>


<section class="py-5">
<div class="container">
    <h2 class="fw-bold mb-4">Nos Produits</h2>
    <?php
        PrintTousLesArticles($pdo)
    ?>
</div>
</section>

<?php
include "inclus/piedPage.inc"
?>