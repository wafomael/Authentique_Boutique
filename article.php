<?php
    include "librairie/fonction.lib.php";

    $pdo = Connect();


    include "inclus/entete.inc";
?>


<section class="py-5">
<div class="container">
    <h2 class="fw-bold mb-4">Nos Produits</h2>


    <?php
    if(isset($_GET['article'])){
        PrintArticle($pdo, intval($_GET['article']));
        echo "
        <div class='container'>
            <h2 class='fw-bold mb-4'>Nos Produits Populaires</h2>
            <div class='row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4'>";

        PrintProduitAlaUne($pdo);

        echo "    </div>
        </div>
        ";
    }
    else{
        PrintTousLesArticles($pdo);
    }

    ?>
</div>
</section>

<?php
include "inclus/piedPage.inc"
?>