<?php
session_start();
require_once('../models/Methodes.php');
$methodes = new Methodes();

if (isset($_POST['action']) && $_POST['action'] === 'add') {
    // Récupération des données du formulaire
    $network = $_POST['network'];
    $address = $_POST['address'];
    $note = $_POST['note'];

    // Ajout de la méthode
    $result = $methodes->addMethod($address, $note, $network);

    if ($result) {
        $_SESSION['MessageS'] = 'Payment method added successfully.';
        // Rediriger vers une page de succès ou afficher un message de confirmation
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        $_SESSION['MessageE'] = 'Something went wrong while adding the method.';
        // Rediriger vers une page de succès ou afficher un message de confirmation
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

elseif (isset($_POST['action']) && $_POST['action'] === 'modify' && isset($_POST['id'])) {
    // Récupération de l'ID et des données du formulaire
    $id = $_POST['id'];
    $network = $_POST['network'];
    $address = $_POST['address'];
    $note = $_POST['note'];

    // Mise à jour de la méthode
    $result = $methodes->updateMethod($id, $address, $note, $network);

    if ($result) {
        $_SESSION['MessageS'] = 'Payment method updated successfully.';
        // Rediriger vers une page de succès ou afficher un message de confirmation
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        $_SESSION['MessageE'] = 'Something went wrong while updating the method.';
        // Rediriger vers une page de succès ou afficher un message de confirmation
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    // Récupération de l'ID de la méthode à supprimer
    $id = $_GET['id'];

    // Suppression de la méthode
    $result = $methodes->deleteMethod($id);

    if ($result) {
        $_SESSION['MessageS'] = 'Method deleted successfully.';
        // Rediriger vers une page de succès ou afficher un message de confirmation
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        $_SESSION['MessageE'] = 'Something went wrong while deleting the method.';
        // Rediriger vers une page de succès ou afficher un message de confirmation
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

else{
    $_SESSION['MessageE'] = 'Something Went Wrong';
    // Rediriger vers une page de succès ou afficher un message de confirmation
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}


