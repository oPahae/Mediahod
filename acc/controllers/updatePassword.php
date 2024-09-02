<?php
session_start();
if(isset($_POST['updatePassword'])){
    if(isset($_SESSION['email']) && isset($_SESSION['etape1']) && isset($_SESSION['etape2']) && isset($_POST['password'])){
       require_once '../models/Utilisateur.php';
       $user = new Utilisateur();
       if($user->changePassword($_SESSION['email'],$_POST['password'])){
        $_SESSION['MessageS'] = 'Your password has been updated successfully. Please log in!';
        // Supprimer les cookies et les variables de session
        unset($_SESSION['etape1']);
        unset($_SESSION['etape2']);
        unset($_SESSION['email']);
        header('Location: ../views/connexion/login.php');
       }
       else{
        $_SESSION['MessageE'] = 'An error occurred. Please try again in a few minutes.';
        header('Location: ../views/connexion/forgot.php');
       }
    }

    else{
        $_SESSION['MessageE'] = 'An error occurred somewhere. Please try again in a few minutes.';
        header('Location: ../views/connexion/forgot.php');
    }
}
?>