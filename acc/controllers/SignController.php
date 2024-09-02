<?php
session_start();

include_once('../models/Utilisateur.php');

// Instancier la classe Utilisateur
$utilisateur = new Utilisateur();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Connexion de l'utilisateur
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validation des données
        if (empty($email) || empty($password)) {
            $_SESSION['MessageE'] = "Veuillez remplir tous les champs.";
            header('Location: ../views/connexion/login.php');
            exit();
        }

        // Vérifier les informations de connexion
        $user = $utilisateur->authenticateUtilisateur($email, $password);

        if ($user) {
            $_SESSION['user'] = $user; // Stocker les informations de l'utilisateur dans la session
            $_SESSION['isConnected'] = true ;
            $_SESSION['MessageS'] = 'You have successfully logged in!';
            //echo "Bonjour" . $_SESSION['user']['username'];
            header('Location: ../views/profile/profile.php'); // Rediriger vers le tableau de bord ou une autre page protégée
            exit();
        } else {
            $_SESSION['MessageE'] = 'Incorrect credentials.';
            header('Location: ../views/connexion/login.php');
            exit();
        }
    } elseif (isset($_POST['register'])) {
        // Inscription de l'utilisateur
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $telephone = $_POST['telephone'];

        // Validation des données
        if (empty($username) || empty($email) || empty($password) || empty($telephone)) {
            $_SESSION['MessageE'] = "Veuillez remplir tous les champs.";
            header('Location: ../views/connexion/register.php');
            exit();
        }

        if($utilisateur->emailExists($email)){
            $_SESSION['MessageE'] = 'Email already in use!';
            header('Location: ../views/connexion/register.php');
            exit();
        }

        // Enregistrer l'utilisateur
        if ($utilisateur->addUtilisateur($username, $email, $password, $telephone)) {
            $_SESSION['MessageS'] = 'Registration successful. You can now log in.';
            echo $_SESSION['MessageS'];
            header('Location: ../views/connexion/login.php'); // Rediriger vers le tableau de bord ou une autre page protégée
            exit();
        } else {
            $_SESSION['MessageE'] = 'An error occurred during registration. Please try again.';
            echo $_SESSION['MessageE'];
            header('Location: ../views/connexion/register.php');
            exit();
        }
    }
} else {
    // Rediriger vers la page de connexion si la requête n'est pas une POST
    header('Location: ../views/connexion/login.php');
    //header('Location: ../views/UserCon.php');
    exit();
}
?>
