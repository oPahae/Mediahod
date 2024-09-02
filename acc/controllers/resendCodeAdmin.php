<?php
session_start();
if(isset($_SESSION['etape1'])){
 //supprimer le code ancien
 setcookie('verification_code', '', time() - 3600);
 //creer nouveau code
 $code = random_int(100000, 999999);
 // Définir le cookie avec le code de vérification
 setcookie('verification_code', $code, time() + 600);
 require_once '../envoyerEmail.php';
 require_once '../models/Admin.php';
 $admin = new Admin();
 resend_code($admin->getEmail(),$code);
 $_SESSION['MessageS'] = 'Please check your email again. A confirmation code has been resent to you.';
 header('Location: ../views/admin/connexion/forgot.php');
}
else{
    $_SESSION['MessageE'] = 'An error has occurred!';
    header('Location: ../views/admin/connexion/login.php');
}
?>