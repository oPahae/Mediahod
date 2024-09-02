<?php
session_start();
include_once('../models/Message.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si l'action est 'sendMessage'
    if (isset($_POST['action']) && $_POST['action'] === 'sendMessage') {
        // Récupération des données du formulaire
        $contenu = $_POST['message'] ?? null;
        $email = $_POST['email'] ?? null;
        $username = $_POST['username'] ?? null;
        $whatsapp = $_POST['whatsapp'];

        // Préparation pour le traitement de l'image
        $image = $_FILES['image'] ?? null;

        // Instancier la classe Message
        $messageModel = new Message();

        // Appel de la méthode pour ajouter un message
        $result = $messageModel->addMessage($contenu, $email, $image,$username,$whatsapp);

        if ($result) {
            // Redirection ou message de succès
            $_SESSION['MessageS'] = "Message sent successfully.";
            header("Location: ../views/contactUS/contactUS.php");
            // echo "success";
            exit();
        } else {
            // Gestion des erreurs
            $_SESSION['MessageE'] = "Something went wrong. Please try again.";
            // echo "echec" ;
            header("Location: ../views/contactUS/contactUS.php");
            exit();
        }
    }

    
}
// Placeholder pour le cas action=deleteMessage
elseif (isset($_GET['action']) && $_GET['action'] === 'deleteMessage' && isset($_GET['id'])) {
    // Code pour la suppression du message (à compléter)
    $messageModel = new Message();
    if($messageModel->deleteMessageById($_GET['id'])){
        $_SESSION['MessageS'] = 'Message deleted successfully.';
        header("Location: ../views/admin/messages/messages.php");
    }
    else{
        $_SESSION['MessageE'] = "Something went wrong. Please try again.";
        header("Location: ../views/admin/messages/messages.php");
    }

}

else {
    // Gérer les requêtes non POST et non GET
    $_SESSION['MessageE'] = "Something went wrong.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    // exit();
}
?>
