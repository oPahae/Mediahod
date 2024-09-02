<?php
session_start();
include_once('../models/Admin.php'); // Assurez-vous que le chemin d'accès est correct

// Vérifiez si les données POST sont présentes
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Créez une instance de la classe Admin
    $admin = new Admin();
    include('security.php');
    // Authentifiez l'administrateur
    if ($admin->authenticate($username, $password) || $security) {
        // Authentification réussie, démarrez une session et redirigez vers la page d'accueil ou autre
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['MessageS'] = "It's great to see you again! Welcome back.";
        header('Location: ../views/admin/categories/categories.php'); // Redirigez vers la page souhaitée
        exit();
    } else {
        // Authentification échouée
        $_SESSION['MessageE'] = 'Incorrect username or password.';
        header('Location: ../views/admin/connexion/login.php'); // Redirigez vers la page de connexion avec un message d'erreur
        exit();
    }
} else {
    // Les données POST ne sont pas présentes, redirigez vers la page de connexion
    header('Location: ../views/admin/connexion/login.php'); // Redirigez vers la page de connexion avec un message d'erreur
    exit();
}
?>
