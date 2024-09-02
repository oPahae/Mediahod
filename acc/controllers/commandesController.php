<?php
session_start();
include_once('../models/Produit.php');
include_once('../models/Commande.php');
include_once('../models/Utilisateur.php');
$produit = new Produit();
$commande = new Commande();
$user = new Utilisateur();
// if someone order an account
if(isset($_POST['action']) && isset($_POST['productId']) && isset($_POST['quantity']) && $_POST['action'] === 'ordernow' && isset($_SESSION['isConnected'])){
// verify if his money is enough or not
$productInfo = $produit->getProduitById($_POST['productId']) ;
$wallet = $user->getUserWalletById($_SESSION['user']['id']);
if($wallet < $productInfo['prix']*$_POST['quantity']){
    $_SESSION['MessageE'] = 'You do not have enough money to place the order. Please deposit funds to continue.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
//else if the money in the wallet is enough
else{
    //in this case we will save the command
    if($commande->addCommande($_POST['quantity'],$_POST['quantity']*$productInfo['prix'],$_POST['productId'],$_SESSION['user']['id'])){
        $_SESSION['MessageS'] = 'Your order has been saved successfully!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        $_SESSION['MessageE'] = 'Something went wrong while trying to save your order. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
}
//the admin wanna reject the command
elseif(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] === 'reject'){
    //try to reject the command
    if($commande->rejectCommande($_GET['id'])){
        $_SESSION['MessageS'] = 'The order has been successfully canceled.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        $_SESSION['MessageE'] = 'Something went wrong. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
elseif (isset($_POST['action']) && isset($_POST['idCom']) && $_POST['action'] === 'confirm') {
    $accountDetails = !empty($_POST['accountDetails']) ? nl2br(htmlspecialchars($_POST['accountDetails'])) : null;
    $file = !empty($_FILES['folder']['tmp_name']) ? $_FILES['folder'] : null;

    // Vérification que l'un des deux (textarea ou fichier) est non nul
    if ($accountDetails === null && $file === null) {
        $_SESSION['MessageE'] = 'You must provide either account details or upload a file.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Essayer de valider la commande
    if ($commande->validerCommand($_POST['idCom'], $accountDetails, $file)) {
        $_SESSION['MessageS'] = 'The order has been successfully validated.';
    } else {
        $_SESSION['MessageE'] = 'Something went wrong. Please try again.';
    }

    // Redirection
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}


elseif(isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] === 'delete'){
            //try to delete
            if($commande->deleteCommande($_GET['id'])){
                $_SESSION['MessageS'] = 'The order has been successfully deleted.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            else{
                $_SESSION['MessageE'] = 'Something went wrong. Please try again later.';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
    }

else{
    // echo "nn";
    $_SESSION['MessageE'] = 'Something went wrong. Please try again later.';
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>