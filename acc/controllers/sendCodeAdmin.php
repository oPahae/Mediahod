<?php
session_start() ;
require_once '../envoyerEmail.php' ;
if(isset($_GET['action']) && $_GET['action']=='forgot'){
    
    require_once '../models/Admin.php' ;
    $admin = new Admin();

        $code = random_int(100000, 999999);
        setcookie('verification_code', $code, time() + 600);
        send_code_verification($admin->getEmail(),$code);
        $_SESSION['MessageS'] = 'Please check your email. A confirmation code has been sent to you.';
        $_SESSION['etape1'] = true ;
        header('Location: ../views/admin/connexion/forgot.php');   

}

else{
    header('Location: ../views/admin/connexion/login.php');   
}



?>