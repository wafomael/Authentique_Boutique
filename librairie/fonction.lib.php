<?php
   function Connect() {
       // Paramètres de connexion
       $host = 'localhost'; // Hôte de la base de données
       $db = 'stock_ab';    // Nom de la base de données
       $user = 'root';      // Nom d'utilisateur
       $password = 'rootKatana';      // Mot de passe de l'utilisateur

         try {
           // Création de la connexion PDO
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8"; // DSN (Data Source Name)
            $pdo = new PDO($dsn, $user, $password);

           // Définir le mode d'erreur de PDO sur Exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           // Retourner l'objet PDO
            return $pdo;
         } catch (PDOException $e) {
           // En cas d'erreur, afficher le message d'erreur
            echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
            return null;
         }
   }

   function PrintColectionAlaUne($bd){
      $sql = "
         SELECT a.id AS article_id, c.id AS collection_id, c.nom AS collection_nom, c.description AS collection_description
         FROM article a
         JOIN collection c ON a.id_collection = c.id
         WHERE a.aLaUne = TRUE AND c.aLaUne = TRUE
         LIMIT 3
      ";
      $stmt = $bd->prepare($sql);
      $stmt->execute();

      // Récupérer les 3 articles/collections dans un tableau
      $collections = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if (count($collections) > 0) {
         // Utiliser la première collection pour le texte
         $first = $collections[0];

         echo '
         <section class="py-5 bg-light">
            <div class="container">
            <div class="row align-items-center">
               <!-- Texte à gauche -->
               <div class="col-md-6 mb-4 mb-md-0">
                  <h2 class="fw-bold">Découvrez les <span class="text-primary">' . htmlspecialchars($first['collection_nom']) . '</span></h2>
                  <p class="text-muted mt-3">
                  ' . nl2br(htmlspecialchars($first['collection_description'])) . '
                  </p>
                  <a href="collection.php?collection=' . urlencode($first['collection_id']) . '" class="btn btn-primary mt-3">En savoir plus</a>
               </div>
               <!-- Images à droite -->
               <div class="col-md-6 d-flex justify-content-center img1_sec1">
                  <div class="d-flex flex-column img1_sec1_sub">
                  <img src="image/articles/' . $collections[0]['article_id'] . '.jpg" class="img-fluid mb-3 rounded shadow" alt="Image 1">';
         // Afficher les images 2 et 3 si elles existent
         if (isset($collections[1])) {
            echo '<img src="image/articles/' . $collections[1]['article_id'] . '.jpg" class="img-fluid rounded shadow" alt="Image 2">';
         }
         echo '</div>';
         if (isset($collections[2])) {
            echo '<img src="image/articles/' . $collections[2]['article_id'] . '.jpg" class="img-fluid ms-3 rounded shadow d-none d-md-block" alt="Image 3">';
         }
         echo '
               </div>
            </div>
            </div>
         </section>';
      } else {
         echo "Aucune collection à la une trouvée.";
      }
   }


   function PrintProduitAlaUne($bd) {
      $sql = "
         SELECT a.id AS article_id, a.nom AS article_nom, a.description AS article_description, a.prix AS article_prix
         FROM article a
         WHERE a.aLaUne = TRUE
         ORDER BY RAND()
         LIMIT 4
      ";
      $stmt = $bd->prepare($sql);
      $stmt->execute();

      while ($article = $stmt->fetch(PDO::FETCH_ASSOC)) {
         echo '<div class="col">
               <div class="card h-100 shadow-sm">
                  <img src="image/articles/'.$article['article_id'].'.jpg" class="card-img-top" alt="Produit 1">
                  <div class="card-body">
                     <h5 class="card-title">'.$article['article_nom'].'</h5>
                     <p class="card-text text-muted">'.$article['article_description'].'</p>
                  </div>
                  <div class="card-footer d-flex justify-content-between align-items-center">
                     <a href="article.php?article='.$article['article_id'].'" class="btn btn-outline-primary">
                        <img class="icon_btn" src="image/info.png" alt="">
                     </a>
                     <button class="btn btn-success"><img class="icon_btn" src="image/shopping-bag.png" alt=""></button>
                     <span class="fw-bold text-danger">'.$article['article_prix'].'$</span>
                  </div>
               </div>
         </div>';
         }
   }


function PrintCollectionsEtProduits($bd) {
   // Récupérer toutes les collections
   $sqlCollections = "SELECT id AS collection_id, nom AS collection_nom, description AS collection_description FROM collection";
   $stmtCollections = $bd->prepare($sqlCollections);
   $stmtCollections->execute();
   $collections = $stmtCollections->fetchAll(PDO::FETCH_ASSOC);

   // Afficher les collections et leurs produits
   foreach ($collections as $collection) {
      echo '<div class="container mt-4">
               <h2 class="text-primary">
                  <a href="collection.php?collection=' . $collection['collection_id'] . '" class="text-decoration-none text-primary">
                     ' . htmlspecialchars($collection['collection_nom']) . '
                  </a>
               </h2>
               <p class="text-muted">' . htmlspecialchars($collection['collection_description']) . '</p>
               <div class="row row-cols-1 row-cols-md-4 g-4">';

      // Récupérer les produits de la collection actuelle
      $sqlProduits = "SELECT id AS article_id, nom AS article_nom, description AS article_description, prix AS article_prix
                     FROM article WHERE id_collection = :collection_id limit 4";
      $stmtProduits = $bd->prepare($sqlProduits);
      $stmtProduits->execute([':collection_id' => $collection['collection_id']]);
      $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

      // Afficher les produits associés
      foreach ($produits as $article) {
         echo '<div class="col">
                  <div class="card h-100 shadow-sm">
                     <img src="image/articles/' . $article['article_id'] . '.jpg" class="card-img-top" alt="' . htmlspecialchars($article['article_nom']) . '">
                     <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($article['article_nom']) . '</h5>
                        <p class="card-text text-muted">' . htmlspecialchars($article['article_description']) . '</p>
                     </div>
                     <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="article.php?article=' . $article['article_id'] . '" class="btn btn-outline-primary">
                           <img class="icon_btn" src="image/info.png" alt="">
                        </a>
                        <button class="btn btn-success"><img class="icon_btn" src="image/shopping-bag.png" alt=""></button>
                        <span class="fw-bold text-danger">' . $article['article_prix'] . '$</span>
                     </div>
                  </div>
               </div>';
      }

      echo '</div></div>'; // Fermeture de la collection
   }
}



   function PrintTousLesArticles($bd) {
      // Requête pour récupérer tous les articles
      $sql = "SELECT a.id AS article_id, a.nom AS article_nom, a.description AS article_description,
                     a.prix AS article_prix, c.nom AS collection_nom
               FROM article a
               LEFT JOIN collection c ON a.id_collection = c.id
               ORDER BY c.nom, a.nom";

      $stmt = $bd->prepare($sql);
      $stmt->execute();
      $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

      echo '<div class="container mt-4">
               <h2 class="text-primary">Tous les Articles</h2>
               <div class="row row-cols-1 row-cols-md-4 g-4">';

      foreach ($articles as $article) {
            echo '<div class="col">
                  <div class="card h-100 shadow-sm">
                     <img src="image/articles/'.$article['article_id'].'.jpg" class="card-img-top" alt="'.$article['article_nom'].'">
                     <div class="card-body">
                        <h5 class="card-title">'.$article['article_nom'].'</h5>
                        <p class="text-muted">'.$article['collection_nom'].'</p>
                        <p class="card-text text-muted">'.$article['article_description'].'</p>
                     </div>
                     <div class="card-footer d-flex justify-content-between align-items-center">
                        <a href="article.php?article='.$article['article_id'].'" class="btn btn-outline-primary">
                           <img class="icon_btn" src="image/info.png" alt="">
                        </a>
                        <button class="btn btn-success"><img class="icon_btn" src="image/shopping-bag.png" alt=""></button>
                        <span class="fw-bold text-danger">'.$article['article_prix'].'$</span>
                     </div>
                  </div>
                  </div>';
      }

      echo '</div></div>'; // Fermeture du container
   }


function PrintArticle($bd, $id) {
   $sql = "
      SELECT a.id, a.nom, a.description, a.prix, a.id_collection,
            c.nom AS collection_nom, c.description AS collection_description
      FROM article a
      LEFT JOIN collection c ON a.id_collection = c.id
      WHERE a.id = ?

   ";
   $stmt = $bd->prepare($sql);
   $stmt->execute([$id]);
   $article = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($article) {
      echo '<h2 class="fw-bold mb-4">Détail du produit</h2>';
      echo '
         <div class="row justify-content-center">
            <div class="col-md-10">
               <div class="card shadow-sm p-3">
                  <div class="row g-0">
                     <div class="col-md-5 d-flex align-items-center">
                        <img src="image/articles/' . $article['id'] . '.jpg" class="img-fluid rounded" alt="Image article">
                     </div>
                     <div class="col-md-7">
                        <div class="card-body">
                           <h3 class="card-title fw-bold">' . htmlspecialchars($article['nom']) . '</h3>
                           <p class="card-text text-muted">' . nl2br(htmlspecialchars($article['description'])) . '</p>
                           <p class="fw-bold text-danger h4 mt-3">' . $article['prix'] . '$</p>';

      // Affichage de la collection si elle existe
      if (!empty($article['collection_nom'])) {
         echo '<div class="mt-4">
                  <h5 class="text-primary">
                     Collection : <a href="collection.php?collection=' . urlencode($article['id_collection']) . '">' 
                     . htmlspecialchars($article['collection_nom']) . '</a>
                  </h5>
                  <p class="text-muted">' . nl2br(htmlspecialchars($article['collection_description'])) . '</p>
               </div>';
      }


      echo '         <div class="mt-4 d-flex gap-3">
                           <a href="article.php" class="btn btn-secondary">
                              <i class="bi bi-arrow-left"></i> Nos articles
                           </a>
                           <button class="btn btn-success">
                              <img class="icon_btn" src="image/shopping-bag.png" alt=""> Ajouter au panier
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>';
   } else {
      echo "<div class='alert alert-warning'>Article non trouvé.</div>";
   }
}


function PrintCollectionDetail($bd, $id) {
   // Récupérer la collection
   $sqlCollection = "SELECT nom, description FROM collection WHERE id = ?";
   $stmt = $bd->prepare($sqlCollection);
   $stmt->execute([$id]);
   $collection = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($collection) {
      echo '<h2 class="fw-bold mb-4 text-primary">'.htmlspecialchars($collection['nom']).'</h2>';
      echo '<p class="text-muted mb-4">'.htmlspecialchars($collection['description']).'</p>';

      // Récupérer les produits de cette collection
      $sqlProduits = "SELECT id AS article_id, nom AS article_nom, description AS article_description, prix AS article_prix
                     FROM article WHERE id_collection = ?";
      $stmtProduits = $bd->prepare($sqlProduits);
      $stmtProduits->execute([$id]);
      $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

      if ($produits) {
         echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">';
         foreach ($produits as $article) {
            echo '<div class="col">
                     <div class="card h-100 shadow-sm">
                        <img src="image/articles/'.$article['article_id'].'.jpg" class="card-img-top" alt="'.$article['article_nom'].'">
                        <div class="card-body">
                           <h5 class="card-title">'.htmlspecialchars($article['article_nom']).'</h5>
                           <p class="card-text text-muted">'.htmlspecialchars($article['article_description']).'</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                           <a href="article.php?article='.$article['article_id'].'" class="btn btn-outline-primary">
                              <img class="icon_btn" src="image/info.png" alt="">
                           </a>
                           <button class="btn btn-success"><img class="icon_btn" src="image/shopping-bag.png" alt=""></button>
                           <span class="fw-bold text-danger">'.$article['article_prix'].'$</span>
                        </div>
                     </div>
                  </div>';
         }
         echo '</div>';
      } else {
         echo "<div class='alert alert-warning'>Aucun article dans cette collection.</div>";
      }

   } else {
      echo "<div class='alert alert-danger'>Collection introuvable.</div>";
   }
}

   ?>