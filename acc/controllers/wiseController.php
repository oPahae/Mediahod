<?php
session_start();
include_once('../models/Wise.php'); // Assurez-vous que le chemin est correct

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'setWise') {
    
    // Récupération des données du formulaire
    $currency = $_POST['currency'];
    $email = $_POST['email'];
    $holderName = $_POST['full-holder-name'];
    $bankName = $_POST['bank-name'];
    $bankCode = $_POST['bank-code'];
    $accountNumber = $_POST['account-number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];

    // Création d'une instance de la classe Wise
    $wise = new Wise();

    // Appel de la méthode updateWise pour mettre à jour les informations
    $result = $wise->updateWise($currency, $email, $holderName, $bankName, $bankCode, $accountNumber, $address, $city, $zipcode);

    // Vérification du résultat et redirection ou affichage d'un message
    if ($result) {
        // Message de succès
        $_SESSION['MessageS'] = 'The Wise information has been successfully updated.';
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#wise-form');
        exit();
    } else {
        // Message d'erreur
        $_SESSION['MessageE'] = 'An error occurred while updating the Wise information. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '#wise-form');
        exit();
    }
}
?>
