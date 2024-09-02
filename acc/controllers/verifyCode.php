<?php
session_start();
if(isset($_COOKIE['verification_code'])){
if(isset($_SESSION['email']) && isset($_SESSION['etape1']) && isset($_POST['code']) && isset($_POST['verifyCode'])){
if($_POST['code'] == $_COOKIE['verification_code']){
  $_SESSION['MessageS'] = 'The code you entered is correct. Please enter a new password for your account.';
  $_SESSION['etape2'] = TRUE ;
  setcookie('verification_code', '', time() - 3600);
  header('Location: ../views/connexion/newPass.php');
}
//si le code saisie est incorrecte
else{
  $_SESSION['MessageE'] = 'The code you entered is incorrect!';
  header('Location: ../views/connexion/verify.php');
}
}
}

else{
  $_SESSION['MessageE'] = 'The code you entered is no longer valid. Please try again later.';
    unset($_SESSION['etape1']);
    unset($_SESSION['email']);
    header('Location: ../views/connexion/forgot.php');
}
?>