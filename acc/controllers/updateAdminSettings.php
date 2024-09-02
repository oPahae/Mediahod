<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='editSettings') {
    // Récupérer les valeurs du formulaire
    include_once('../models/Admin.php');
    $admin = new Admin();
    $currentPass = $_POST['oldPassword'] ?? '';
    $newUsername = $_POST['username'] ?? '';
    $newPassword = $_POST['password'] ?? '';
    $newEmail= $_POST['email'] ?? '';

    // Appeler la méthode pour mettre à jour les informations de l'administrateur
    $result = $admin->updateAdminSettings($currentPass, $newUsername, $newPassword , $newEmail);

    if ($result) {
        $_SESSION['MessageS'] = 'The informations has been updated successfully.';
        // echo "sucess";
    } else {
        $_SESSION['MessageE'] = 'The current password is incorrect. Please try again.';
        // echo "failed" ;
    }

    // Rediriger vers la page de paramètres
    header('Location: ../views/admin/settings/settings.php');
    exit();

}

else{
    // echo "post ne marche pas";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>
