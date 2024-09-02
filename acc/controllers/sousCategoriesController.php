<?php
session_start();
include_once('../models/SousCategorie.php');

// Vérifier si l'action est définie dans la requête POST
// if (isset($_POST['action'])) {
    $sousCategorie = new SousCategorie();

    if (isset($_POST['action']) && $_POST['action'] === 'addSub') {
        $nom = $_POST['subcategory-name'];
        $idCategorie = $_POST['category'];

        // Validation des entrées
        if (!empty($nom) && !empty($idCategorie)) {
            // Appel à la méthode addSousCategorie
            $result = $sousCategorie->addSousCategorie($nom, $idCategorie);

            if ($result) {
                // $_SESSION['MessageS'] = 'SubCategory ' . $_POST['subcategory-name'] . ' added successfully';
                $_SESSION['MessageS'] = 'The subcategory "' . htmlspecialchars($_POST['subcategory-name'], ENT_QUOTES, 'UTF-8') . '" has been added successfully.';
                $revenir = "#subcategory-form";
                header('Location: ' . $_SERVER['HTTP_REFERER'] . $revenir);
            } else {
                // $_SESSION['MessageS'] = 'Failed to add SubCategory ' . $_POST['subcategory-name'];
                $_SESSION['MessageS'] = 'Failed to add the subcategory "' . htmlspecialchars($_POST['subcategory-name'], ENT_QUOTES, 'UTF-8') . '". Please try again.';
                $revenir = "#subcategory-form";
                header('Location: ' . $_SERVER['HTTP_REFERER'] . $revenir);
            }
        } else {
            die("Error: Name and category are required.");
        }
    } 
     else if (isset($_POST['action']) && $_POST['action'] === 'modifySub') {
        $id = $_POST['idSubCat'];
        $nom = $_POST['label'];
        $idCategorie = $_POST['category'];

        // Validation des entrées
        if (!empty($id) && !empty($nom) && !empty($idCategorie)) {
            // Appel à la méthode updateSousCategorieById
            $result = $sousCategorie->updateSousCategorieById($id, $nom, $idCategorie);

            if ($result) {
                // $_SESSION['MessageS'] = 'SubCategory ' . $_POST['label'] . ' updated successfully';
                $_SESSION['MessageS'] = 'The subcategory "' . htmlspecialchars($_POST['label'], ENT_QUOTES, 'UTF-8') . '" has been updated successfully.';
                header('Location: ../views/admin/categories/modifySubCat.php?idSub=' . $id);
            } else {
                // $_SESSION['MessageE'] = 'Failed to update SubCategory ' . $_POST['label'];
                $_SESSION['MessageE'] = 'Failed to update the subcategory "' . htmlspecialchars($_POST['label'], ENT_QUOTES, 'UTF-8') . '". Please try again.';
                header('Location: ../views/admin/categories/modifySubCat.php?idSub=' . $id);
            }
        } else {
            die("Error: ID, name, and category are required.");
        }
    }
// }

elseif(isset($_GET['action']) && $_GET['action'] === 'deleteSub' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($sousCategorie->deleteSousCategorieById($id)) {
        // echo "Sous-catégorie supprimée avec succès.";
        // $_SESSION['MessageS'] = 'SubCategory Deleted With Success' ;
        $_SESSION['MessageS'] = 'The subcategory has been successfully deleted.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        // echo "Erreur: La sous-catégorie n'a pas pu être supprimée.";
        // $_SESSION['MessageE'] = 'SubCategory Could Not Be Deleted';
        $_SESSION['MessageE'] = 'The subcategory could not be deleted. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

else{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}



?>
