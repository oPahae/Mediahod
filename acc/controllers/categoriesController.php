<?php
session_start();
include_once('../models/Categorie.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);


    $categorie = new Categorie();

    if (isset($_POST['action']) && $_POST['action'] === 'addCat') {
        $nom = $_POST['category-name'];
        var_dump($_FILES); // Pour déboguer

        if (isset($_FILES['imageCat']) && $_FILES['imageCat']['error'] === UPLOAD_ERR_OK) {
            $result = $categorie->addCategorie($nom, $_FILES['imageCat']);

            if ($result) {
                // $_SESSION['MessageS'] = 'Category ' . $_POST['category-name'] . ' added successfully';
                $_SESSION['MessageS'] = 'The category "' . htmlspecialchars($_POST['category-name'], ENT_QUOTES, 'UTF-8') . '" has been added successfully.';
            } else {
                // $_SESSION['MessageE'] = 'Failed to add category ' . $_POST['category-name'];
                $_SESSION['MessageE'] = 'Failed to add the category "' . htmlspecialchars($_POST['category-name'], ENT_QUOTES, 'UTF-8') . '". Please try again.';
            }
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '#addCat');
            exit();
        } else {
            $_SESSION['MessageE'] = 'An error occurred while uploading the file. Please try again.';
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '#addCat');
            exit();
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'modifyCat') {
        $id = isset($_POST['idCat']) ? intval($_POST['idCat']) : 0;
        $nom = isset($_POST['label']) ? $_POST['label'] : '';
        $imageFile = isset($_FILES['imageCat']) && $_FILES['imageCat']['error'] === UPLOAD_ERR_OK ? $_FILES['imageCat'] : null;

        // Validation des données
        if (empty($id) || empty($nom)) {
            echo 'Required fields are missing!';
        } else {
            // Appel à la méthode updateCategorieById
            $result = $categorie->updateCategorieById($id, $nom, $imageFile);

            if ($result) {
                //echo 'Category ' . $_POST['label'] . ' updated successfully';
                // $_SESSION['MessageS'] = 'Category ' . $_POST['label'] . ' updated successfully' ;
                $_SESSION['MessageS'] = 'The category "' . htmlspecialchars($_POST['label'], ENT_QUOTES, 'UTF-8') . '" has been updated successfully.';
                header('Location: ../views/admin/categories/modifyCat.php?idCat=' . $id);
            } else {
                //echo 'Failed to update category ' . $_POST['label'];
                // $_SESSION['MessageE'] = 'Failed to update category ' . $_POST['label'] ;
                $_SESSION['MessageE'] = 'Failed to update the category "' . htmlspecialchars($_POST['label'], ENT_QUOTES, 'UTF-8') . '". Please try again.';
                header('Location: ../views/admin/categories/modifyCat.php?idCat=' . $id);
            }
        }
    } elseif (isset($_GET['action']) && $_GET['action'] === 'deleteCat' && isset($_GET['id'])) {
        // Traitement de la suppression (à faire plus tard)
        if($categorie->deleteCategorieById($_GET['id'])){
            // $_SESSION['MessageS'] = 'Category Deleted With All SubCategories And Products Successfuly';
            $_SESSION['MessageS'] = 'The category, along with all its subcategories and products, has been successfully deleted.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else{
            $_SESSION['MessageE'] = 'The category could not be deleted. Please try again.';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    else{
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>
