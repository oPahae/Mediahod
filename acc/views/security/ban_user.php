<?php
session_start();

// Récupérer l'adresse IP de l'utilisateur
$ip = $_SERVER['REMOTE_ADDR'];

// Vérifier si l'utilisateur est déjà banni
if (isset($_SESSION['banned']) && $_SESSION['banned']['ip'] === $ip) {
    header('Location: banned.php');
    exit();
}

// Déterminer la durée du ban (5 minutes)
$ban_duration = 10; // 5 minutes en secondes
$ban_time = time() + $ban_duration;

// Enregistrer l'IP bannie dans la session
$_SESSION['banned'] = ['ip' => $ip, 'ban_time' => $ban_time];

// Récupérer la localisation de l'utilisateur avec ipinfo.io
$location_data = @file_get_contents("https://ipinfo.io/{$ip}/json"); // Utilisation de @ pour éviter les warnings en cas d'erreur

if ($location_data === false) {
    $location = ['city' => 'Unknown', 'region' => 'Unknown', 'country' => 'Unknown', 'org' => 'Unknown'];
} else {
    $location = json_decode($location_data, true);
}

// Débogage : Afficher la réponse brute de l'API
// echo '<pre>'; print_r($location); echo '</pre>'; exit;

// Stocker les informations bannies dans un fichier JSON sous forme de tableau
$banned_users_file = 'banned_users.json';
$banned_users = file_exists($banned_users_file) ? json_decode(file_get_contents($banned_users_file), true) : [];

// Ajouter les informations de l'utilisateur banni
$banned_users[] = [
    'ip' => $ip,
    'ban_time' => date('Y-m-d H:i:s', $ban_time),
    'location' => 'Near Casablanca-Settat',
    'region' => 'Unknown',
    'country' => 'Morocco',
    'isp' => 'ips'
];

// Enregistrer dans le fichier JSON
file_put_contents($banned_users_file, json_encode($banned_users, JSON_PRETTY_PRINT));

// Rediriger vers la page de bannissement
header('Location: banned.php');
exit();
?>
