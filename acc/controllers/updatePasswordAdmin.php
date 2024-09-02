<?php
session_start();
if(isset($_POST['updatePassword'])){
    if(isset($_SESSION['etape1']) && isset($_SESSION['etape2']) && isset($_POST['newPassword']) && isset($_POST['newLogin']) ){
       require_once '../models/Admin.php';
       $admin = new Admin();
       if($admin->changePassword($_POST['newPassword'],$_POST['newLogin'])){
        $_SESSION['MessageS'] = 'Your password has been updated successfully. Please log in!';
        // Supprimer les cookies et les variables de session
        unset($_SESSION['etape1']);
        unset($_SESSION['etape2']);
        header('Location: ../views/admin/connexion/login.php');
       }
       else{
        $_SESSION['MessageE'] = 'An error occurred somewhere. Please try again in a few minutes.';
        header('Location: ../views/admin/connexion/login.php');
       }
    }

    else{
        $_SESSION['MessageE'] = 'An error occurred somewhere. Please try again in a few minutes.';
        header('Location: ../views/admin/connexion/login.php');
    }
}
?>