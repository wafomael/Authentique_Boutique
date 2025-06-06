<?php
include "librairie/fonction.lib.php";
$pdo = Connect();
include "inclus/entete.inc";
?>

<section class="py-5">
<div class="container">

<?php
if (isset($_GET['collection']) && is_numeric($_GET['collection'])) {
    PrintCollectionDetail($pdo, intval($_GET['collection']));

    // Produits populaires ensuite
    echo "
    <div class='container mt-5'>
        <h2 class='fw-bold mb-4 text-primary'>Produits Populaires</h2>
        <div class='row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4'>";
    PrintProduitAlaUne($pdo);
    echo "    </div>
    </div>
    ";
} else {
    echo '<h2 class="fw-bold mb-4">Nos Collections</h2>';
    PrintCollectionsEtProduits($pdo);
}
?>

</div>
</section>

<?php include "inclus/piedPage.inc"; ?>
