<?php
session_start();
include_once('../models/AboutUs.php'); // Assurez-vous que le chemin est correct

// Vérifier si l'action est bien définie
if (isset($_POST['action']) && $_POST['action'] === 'aboutUs') {
    // Récupérer le texte du formulaire
    $aboutUsContent = $_POST['aboutUs-name'];

    // Créer une instance de la classe AboutUs
    $aboutUs = new AboutUs();

    // Mettre à jour le contenu
    $updateResult = $aboutUs->updateContent($aboutUsContent);

    // Vérifier le résultat de la mise à jour
    if ($updateResult) {
        $_SESSION['MessageS'] = 'The content has been successfully updated.';
    } else {
        $_SESSION['MessageE'] = 'Failed to update the content.';
    }

    // Rediriger vers la page précédente avec un message
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '#aboutUs-form');
    exit();
}
?>
