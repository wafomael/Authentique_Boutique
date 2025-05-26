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
         SELECT a.id AS article_id, c.nom AS collection_nom, c.description AS collection_description
         FROM article a
         JOIN collection c ON a.id_collection = c.id
         WHERE a.aLaUne = TRUE AND c.aLaUne = TRUE
         LIMIT 3
      ";
      $stmt = $bd->prepare($sql);
      $stmt->execute();
   
       // Vérifier si la collection existe
      $collection = $stmt->fetch(PDO::FETCH_ASSOC);
   
       // Si la collection existe, retourner les données, sinon retourner un message
      if ($collection) {
         echo '
               <section class="py-5 bg-light">
         <div class="container">
         <div class="row align-items-center">
            <!-- Texte à gauche -->
            <div class="col-md-6 mb-4 mb-md-0">
               <h2 class="fw-bold">Découvrez les <span class="text-primary">'.$collection['collection_nom'].'</span></h2>
               <p class="text-muted mt-3">
                  '.$collection['collection_description'].'
               </p>
               <a href="#" class="btn btn-primary mt-3">En savoir plus</a>
            </div>
            <!-- Images à droite -->
            <div class="col-md-6 d-flex justify-content-center img1_sec1">
               <div class="d-flex flex-column img1_sec1_sub">
                  <img src="image/articles/'.$collection['article_id'].'.jpg" class="img-fluid mb-3 rounded shadow" alt="Image 1">
                  ';
   
         $collection = $stmt->fetch(PDO::FETCH_ASSOC);
               
         echo '
                  <img src="image/articles/'.$collection['article_id'].'.jpg" class="img-fluid rounded shadow" alt="Image 2">
               </div>';
   
         $collection = $stmt->fetch(PDO::FETCH_ASSOC);
         echo '
               <img src="image/articles/'.$collection['article_id'].'.jpg" class="img-fluid ms-3 rounded shadow d-none d-md-block" alt="Image 3">
            </div>
         </div>
      </div>
   </section>
         ';
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
                     <button class="btn btn-outline-primary"><img class="icon_btn" src="image/info.png" alt=""></button>
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
                  <h2 class="text-primary">'.$collection['collection_nom'].'</h2>
                  <p class="text-muted">'.$collection['collection_description'].'</p>
                  <div class="row row-cols-1 row-cols-md-4 g-4">';

            // Récupérer les produits de la collection actuelle
            $sqlProduits = "SELECT id AS article_id, nom AS article_nom, description AS article_description, prix AS article_prix 
                           FROM article WHERE id_collection = :collection_id";
            $stmtProduits = $bd->prepare($sqlProduits);
            $stmtProduits->execute([':collection_id' => $collection['collection_id']]);
            $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

            // Afficher les produits associés
            foreach ($produits as $article) {
               echo '<div class="col">
                        <div class="card h-100 shadow-sm">
                           <img src="image/articles/'.$article['article_id'].'.jpg" class="card-img-top" alt="'.$article['article_nom'].'">
                           <div class="card-body">
                              <h5 class="card-title">'.$article['article_nom'].'</h5>
                              <p class="card-text text-muted">'.$article['article_description'].'</p>
                           </div>
                           <div class="card-footer d-flex justify-content-between align-items-center">
                              <button class="btn btn-outline-primary"><img class="icon_btn" src="image/info.png" alt=""></button>
                              <button class="btn btn-success"><img class="icon_btn" src="image/shopping-bag.png" alt=""></button>
                              <span class="fw-bold text-danger">'.$article['article_prix'].'$</span>
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
                     <button class="btn btn-outline-primary"><img class="icon_btn" src="image/info.png" alt=""></button>
                     <button class="btn btn-success"><img class="icon_btn" src="image/shopping-bag.png" alt=""></button>
                     <span class="fw-bold text-danger">'.$article['article_prix'].'$</span>
                  </div>
               </div>
               </div>';
   }

   echo '</div></div>'; // Fermeture du container
}


   ?>