<?php
session_start() ;
require_once '../envoyerEmail.php' ;
if(isset($_POST['sendMail']) && isset($_POST['email'])){
    
    require_once '../models/Utilisateur.php' ;
    $user = new Utilisateur();
    //si le email existe
    if($user->emailExists($_POST['email']) > 0){
        $code = random_int(100000, 999999);
        setcookie('verification_code', $code, time() + 600);
        send_code_verification($_POST['email'],$code);
        $_SESSION['MessageS'] = 'Please check your email. A confirmation code has been sent to you.';
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['etape1'] = true ;
        header('Location: ../views/connexion/verify.php');
    }
    //si le email n'existe pas
    else{
        $_SESSION['MessageE'] = 'No account found with this email! <a href="register.php">Register here</a>.';
        header('Location: ../views/connexion/forgot.php');
    }

}




?>