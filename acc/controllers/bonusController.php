<?php
session_start(); // Assurez-vous que la session est démarrée
include_once('../models/Bonus.php'); // Assurez-vous que le chemin est correct

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'setBonus') {
    
    // Récupération des données du formulaire
    $bonusName = $_POST['bonus-name'];

    // Création d'une instance de la classe Bonus
    $bonus = new Bonus();

    // Appel de la méthode updateBonus pour mettre à jour les informations
    $result = $bonus->updateBonus($bonusName);

    // Vérification du résultat et redirection ou affichage d'un message
    if ($result) {
        // Message de succès
        $_SESSION['MessageS'] = 'The bonus information has been successfully updated.';
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#bonus-form');
        exit();
    } else {
        // Message d'erreur
        $_SESSION['MessageE'] = 'An error occurred while updating the bonus information. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#bonus-form');
        exit();
    }
}
?>
