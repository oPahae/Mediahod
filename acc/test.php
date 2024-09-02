<?php
// Inclure le fichier contenant la classe
// include_once('models/Produit.php');

// Créer une instance de la classe
// $produit = new Produit();

// Appeler la méthode pour récupérer les sous-catégories avec les produits
// $sousCategories = $produit->getSousCategoriesWithProducts(5);

// if ($sousCategories !== false) {
    // Afficher les clés disponibles dans le premier élément
    // if (!empty($sousCategories)) {
    //     $firstElement = reset($sousCategories);
    //     echo "<pre>";
    //     print_r(array_keys($firstElement));
    //     echo "</pre>";
    // }

    // foreach ($sousCategories as $sousCategorie) {
    //     echo "Sous-Catégorie ID: " . $sousCategorie['id'] . "<br>";
    //     echo "Nom de la Sous-Catégorie: " . $sousCategorie['nom'] . "<br>";

        // Vérifier si des produits existent pour cette sous-catégorie
//         if (!empty($sousCategorie['produits'])) {
//             echo "Produits:<br>";
//             foreach ($sousCategorie['produits'] as $produit) {
//                 echo "- Produit ID: " . $produit['id'] . "<br>";
//                 echo "  Label: " . $produit['label'] . "<br>";
//                 echo "  Prix: " . $produit['price'] . "<br>";
//                 echo "  Stock: " . $produit['stock'] . "<br>";
//                 echo "  Description: " . $produit['description'] . "<br>";
//                 echo "  Image: <img src='" . $produit['image'] . "' alt='Image du produit' style='width: 100px;'><br>";
//                 echo "  Logo: <img src='" . $produit['logo'] . "' alt='Logo du produit' style='width: 50px;'><br>";
//                 echo "  Date: " . $produit['date'] . "<br>";
//                 echo "  Lien: <a href='" . $produit['link'] . "'>Voir le produit</a><br>";
//             }
//         } else {
//             echo "Aucun produit pour cette sous-catégorie.<br>";
//         }
        
//         echo "<hr>";
//     }
// } else {
//     echo "Erreur lors de la récupération des sous-catégories et des produits.";
// }

// session_start();
// include_once('models/Utilisateur.php');
//     $user = new Utilisateur();
//     $wallet = $user->getUserWalletById($_SESSION['user']['id']);
//     echo $wallet ;


// session_start();
// include_once('models/Commande.php');
// $commande = new Commande();
// $allCommandes = $commande->getAllCommandsWithProductDetailsByUserId($_SESSION['user']['id']);

// var_dump($allCommandes);

// include_once('models/Bonus.php');
// $bonus = new Bonus();
// $bonusData = $bonus->getBonus();
// echo $bonusData ;