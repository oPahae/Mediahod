<?php
session_start();

// Vérifier si l'utilisateur est banni
if (!isset($_SESSION['banned'])) {
    header('Location: ../home/home.php'); // Redirige vers la page d'accueil si pas banni
    exit();
}

// Calculer le temps restant de bannissement
$remaining_time = $_SESSION['banned']['ban_time'] - time();
if ($remaining_time <= 0) {
    // Si le temps de bannissement est écoulé, enlever le ba
    
    unset($_SESSION['banned']);
    header('Location: ../home/home.php'); // Redirige vers la page d'accueil
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Banned</title>
    <link rel="icon" href="../assets/logo.jpeg">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: red;
            color: #fff;
            font-family: cursive;
        }
    </style>
</head>
<body>
    <h1>You are banned for 10 secondes.</h1>
    <h3>Reason: SQL Injection</h3>
</body>
</html>
