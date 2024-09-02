<?php
session_start();
include_once('../models/Utilisateur.php');

// Créez une instance de la classe Utilisateur
$utilisateur = new Utilisateur();

// Vérifiez l'action à exécuter
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'updateUser':
            // Récupérer les données du formulaire
            $id = $_SESSION['user']['id'];
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $password = isset($_POST['password']) ? $_POST['password'] : null;
            $username = isset($_POST['username']) ? $_POST['username'] : null;
            $telephone = isset($_POST['phone']) ? $_POST['phone'] : null;
            $profile = isset($_FILES['image']) ? $_FILES['image'] : null;

            // Mettre à jour l'utilisateur
            if ($utilisateur->updateUser($id, $email, $password, $username, $telephone, $profile)) {
                $_SESSION['MessageS'] = 'Update successful.';
                header('Location: ../views/profile/profile.php'); // Rediriger vers la page de profil ou une autre page appropriée
                exit();
            } else {
                $_SESSION['MessageE'] = 'An error occurred during the update.';
                header('Location: ../views/profile/profile.php'); // Rediriger vers la page de profil ou une autre page appropriée
                exit();
            }
            break;

        case 'deleteUser':
            // Code pour gérer la suppression de l'utilisateur (à traiter plus tard)
            break;

        case 'setWallet':
            // Code pour gérer la mise à jour du portefeuille (à traiter plus tard)
            if(isset($_POST['userId']) && isset($_POST['amount'])){
                if($utilisateur->updateWallet($_POST['userId'],$_POST['amount'])){
                    $_SESSION['MessageS'] = 'The Wallet Has Been Updated Successfuly';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
                else{
                    $_SESSION['MessageE'] = 'The Wallet Could Not Be Updated , It is possible that the id is not defined';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            }
            break;

        default:
        $_SESSION['MessageE'] = 'Unrecognized action.';
        header('Location: ../views/profile/profile.php'); // Rediriger vers la page de profil ou une autre page appropriée
            exit();
    }
} else {
    $_SESSION['MessageE'] = 'Unrecognized action.';
    header('Location: ../views/profile/profile.php'); // Rediriger vers la page de profil ou une autre page appropriée
    exit();
}
