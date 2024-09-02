<?php
session_start();
include_once('../models/Produit.php');

$produit = new Produit();

if (isset($_POST['action']) && $_POST['action'] === 'addPro') {
    $libelle = $_POST['label'];
    $prix = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $idSousCategorie = $_POST['subCat'];
    $link = isset($_POST['link']) ? $_POST['link'] : null; // Récupérer le lien, s'il est fourni

    // Vérifier si les fichiers sont uploadés
    $imageFile = isset($_FILES['image']) ? $_FILES['image'] : null;
    $logoFile = isset($_FILES['logo']) ? $_FILES['logo'] : null;

    // Vérifier que le logo est fourni
    if (!$logoFile || $logoFile['error'] !== UPLOAD_ERR_OK) {
        die("Error: Logo file is required.");
    }

    // Ajouter le produit
    $result = $produit->addProduit($libelle, $prix, $description, $imageFile, $logoFile, $stock, $idSousCategorie, $link);

    if ($result) {
        //echo "Product added successfully.";
        $_SESSION['MessageS'] = 'The product has been added successfully.';
        header('Location: ../views/admin/addProduct/addProduct.php#product-form');
        // Redirection ou autre action après ajout réussi
    } else {
        // echo "Error: Could not add product.";
        $_SESSION['MessageE'] = 'The product could not be added. Please try again.';
        header('Location: ../views/admin/addProduct/addProduct.php#product-form');
    }
} elseif (isset($_POST['action']) && $_POST['action'] === 'modifyPro') {
    $id = $_POST['id']; // Assure-toi que l'ID du produit est passé
    $libelle = $_POST['label'];
    $prix = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $idSousCategorie = $_POST['subCat'];
    $link = isset($_POST['link']) ? $_POST['link'] : null;

    // Vérifier si les fichiers sont uploadés
    $imageFile = isset($_FILES['image']) ? $_FILES['image'] : null;
    $logoFile = isset($_FILES['logo']) ? $_FILES['logo'] : null;

    // Mettre à jour le produit
    $result = $produit->updateProduit($id, $libelle, $prix, $description, $imageFile, $logoFile, $stock, $idSousCategorie, $link);

    if ($result) {
        // echo "Product updated successfully.";
        $_SESSION['MessageS'] = 'The product has been updated successfully.';
        header('Location: ../views/admin/categories/modifyProd.php?idProd=' . $id);
        // Redirection ou autre action après mise à jour réussie
    } else {
        // echo "Error: Could not update product.";
        $_SESSION['MessageE'] = 'The product could not be updated. Please try again.';
        header('Location: ../views/admin/categories/modifyProd.php?idProd=' . $id);
    }
} elseif (isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] === 'deletePro') {
    // Code pour supprimer le produit
    if($produit->deleteProduitById($_GET['id'])){
        //echo "Product Deleted Successfuly !";
        $_SESSION['MessageS'] = 'The product has been deleted successfully.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        // echo "Product Could Not Be Deleted !";
        $_SESSION['MessageE'] = 'The product could not be deleted. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    die("Error: Invalid action.");
}
?>
