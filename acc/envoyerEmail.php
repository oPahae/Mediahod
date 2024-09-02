<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/phpmailer/phpmailer/src/Exception.php';
require_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once 'vendor/phpmailer/phpmailer/src/SMTP.php';

// function send_mail_validation($idCom, $username, $dateCom ,$emailDeClient) {
//     $mail = new PHPMailer(true);

//     try {
//         // Paramètres SMTP
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP
//         $mail->SMTPAuth = true;
//         $mail->Username = 'votre.email@gmail.com'; // Votre adresse e-mail SMTP
//         $mail->Password = 'votre_mot_de_passe'; // Votre mot de passe SMTP
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;

//         // Destinataire
//         $mail->setFrom('votre.email@gmail.com', 'Comptix'); // Votre adresse e-mail et nom
//         $mail->addAddress($emailDeClient); // Adresse e-mail du destinataire

//         // Contenu de l'e-mail
//         $mail->isHTML(true);
//         $mail->Subject = 'Validation de votre commande';
//         $mail->Body = "
//         <div style='font-family: Arial, sans-serif; color: #333;'>
//             <h1 style='color: #4169E1;'>Validation de votre commande</h1>
//             <p>Bonjour $username,</p>
//             <p>Nous sommes heureux de vous informer que votre commande numéro <strong>$idCom</strong> passée le <strong>$dateCom</strong> a été validée par <strong>Comptix</strong>.</p>
//             <p>Merci d'avoir choisi <strong>Comptix</strong> pour vos achats ! Nous espérons que vous serez satisfait de votre commande.</p>
//             <p>Si vous avez des questions ou des préoccupations, n'hésitez pas à contacter notre <a href='http://votre_site/contact.php' style='color: #4169E1;'>service client</a>.</p>
//             <p>Cordialement,</p>
//             <p><strong>L'équipe de Comptix</strong></p>
//             <hr style='border: 0; border-top: 1px solid #ccc;'>
//             <p style='font-size: 0.9em; color: #555;'>Cet email a été généré automatiquement. Merci de ne pas y répondre directement.</p>
//         </div>
//     ";

//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         return false;
//     }
// }





// function send_mail_annulation($idCom, $username, $dateCom ,$emailDeClient) {
//     $mail = new PHPMailer(true);

//     try {
//         // Paramètres SMTP
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP
//         $mail->SMTPAuth = true;
//         $mail->Username = 'wafik.red.fst@uhp.ac.ma'; // Votre adresse e-mail SMTP
//         $mail->Password = 'F136401894@#cat>fich'; // Votre mot de passe SMTP
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;

//         // Destinataire
//         $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD'); // Votre adresse e-mail et nom
//         $mail->addAddress($emailDeClient); // Adresse e-mail du destinataire

//         // Contenu de l'e-mail
//         $mail->isHTML(true);
//         $mail->Subject = 'Annulation de votre commande';
//         $mail->Body = "
//         <div style='font-family: Arial, sans-serif; color: #333;'>
//             <h1 style='color: #E74C3C;'>Annulation de votre commande</h1>
//             <p>Bonjour $username,</p>
//             <p>Nous regrettons de vous informer que votre commande numéro <strong>$idCom</strong> passée le <strong>$dateCom</strong> a été annulée par <strong>Comptix</strong>.</p>
//             <p>Nous nous excusons pour tout inconvénient que cela pourrait causer. Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter notre <a href='http://votre_site/contact.php' style='color: #E74C3C;'>service client</a>.</p>
//             <p>Cordialement,</p>
//             <p><strong>L'équipe de Comptix</strong></p>
//             <hr style='border: 0; border-top: 1px solid #ccc;'>
//             <p style='font-size: 0.9em; color: #555;'>Cet email a été généré automatiquement. Merci de ne pas y répondre directement.</p>
//         </div>
//     ";

//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         return false;
//     }
// }


// function send_code_verification($emailDeClient,$code) {
//     $mail = new PHPMailer(true);

//     try {
//         // Paramètres SMTP
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP
//         $mail->SMTPAuth = true;
//         $mail->Username = 'wafik.red.fst@uhp.ac.ma'; // Votre adresse e-mail SMTP
//         $mail->Password = 'F136401894@#cat>fich'; // Votre mot de passe SMTP
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;

//         // Destinataire
//         $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD'); // Votre adresse e-mail et nom
//         $mail->addAddress($emailDeClient); // Adresse e-mail du destinataire

//         // Contenu de l'e-mail
//         $mail->isHTML(true);
//         $mail->Subject = 'Code De Verification Pour Recuperer Votre Mot De Passe';
//         $mail->Body = "
//         <div style='font-family: Arial, sans-serif; color: #333;'>
//             <h1 style='color: #4169E1;'>Code de vérification</h1>
//             <p>Bonjour,</p>
//             <p>Voici votre code de vérification composé de 6 chiffres. Ce code est valide pendant 10 minutes :</p>
//             <h1 style='color: red;'>" . $code . "</h1>
//             <p>Si vous n'avez pas demandé ce code, veuillez ignorer cet email.</p>
//             <p>Merci de votre confiance,</p>
//             <p><strong>L'équipe de MEDIAHOD</strong></p>
//             <hr style='border: 0; border-top: 1px solid #ccc;'>
//             <p style='font-size: 0.9em; color: #555;'>Cet email a été généré automatiquement. Merci de ne pas y répondre directement.</p>
//         </div>
//     ";
    
//         // Pièce jointe
//         $mail->send();
//         echo 'E-mail envoyé avec succès à ' . $emailDeClient;
//     } catch (Exception $e) {
//         echo 'Erreur lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
//     }
// }

// function resend_code($emailDeClient, $code) {
//     $mail = new PHPMailer(true);

//     try {
//         // Paramètres SMTP
//         $mail->isSMTP();
//         $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP
//         $mail->SMTPAuth = true;
//         $mail->Username = 'wafik.red.fst@uhp.ac.ma'; // Votre adresse e-mail SMTP
//         $mail->Password = 'F136401894@#cat>fich'; // Votre mot de passe SMTP
//         $mail->SMTPSecure = 'tls';
//         $mail->Port = 587;

//         // Destinataire
//         $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD'); // Votre adresse e-mail et nom
//         $mail->addAddress($emailDeClient); // Adresse e-mail du destinataire

//         // Contenu de l'e-mail
//         $mail->isHTML(true);
//         $mail->Subject = 'Renvoyé: Code De Verification Pour Recuperer Votre Mot De Passe';
//         $mail->Body = "
//         <div style='font-family: Arial, sans-serif; color: #333;'>
//             <h1 style='color: #4169E1;'>Code de vérification</h1>
//             <p>Bonjour,</p>
//             <p>Nous vous avons renvoyé un nouveau code de vérification composé de 6 chiffres. Ce code est valide pendant 10 minutes :</p>
//             <h1 style='color: red;'>" . $code . "</h1>
//             <p>Si vous n'avez pas demandé ce code, veuillez ignorer cet email.</p>
//             <p>Merci de votre confiance,</p>
//             <p><strong>L'équipe de MEDIAHOD</strong></p>
//             <hr style='border: 0; border-top: 1px solid #ccc;'>
//             <p style='font-size: 0.9em; color: #555;'>Cet email a été généré automatiquement. Merci de ne pas y répondre directement.</p>
//         </div>
//     ";
    
//         // Pièce jointe
//         $mail->send();
//         echo 'E-mail de renvoi envoyé avec succès à ' . $emailDeClient;
//     } catch (Exception $e) {
//         echo 'Erreur lors de l\'envoi de l\'e-mail de renvoi : ' . $mail->ErrorInfo;
//     }
// }

function send_code_verification($clientEmail, $code) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'wafik.red.fst@uhp.ac.ma'; // Your SMTP email address
        $mail->Password = 'F136401894@#cat>fich'; // Your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipient
        $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD'); // Your email address and name
        $mail->addAddress($clientEmail); // Recipient email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code to Recover Your Password';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333;'>
            <h1 style='color: #4169E1;'>Verification Code</h1>
            <p>Hello,</p>
            <p>Please find below your 6-digit verification code. This code is valid for 10 minutes:</p>
            <h1 style='color: red;'>" . $code . "</h1>
            <p>If you did not request this code, please disregard this email.</p>
            <p>Thank you for trusting us,</p>
            <p><strong>The MEDIAHOD Team</strong></p>
            <hr style='border: 0; border-top: 1px solid #ccc;'>
            <p style='font-size: 0.9em; color: #555;'>This email was generated automatically. Please do not reply directly to this email.</p>
        </div>
    ";

        // Send email
        $mail->send();
        echo 'Verification email successfully sent to ' . $clientEmail;
    } catch (Exception $e) {
        echo 'Error sending verification email: ' . $mail->ErrorInfo;
    }
}

function resend_code($clientEmail, $code) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server address
        $mail->SMTPAuth = true;
        $mail->Username = 'wafik.red.fst@uhp.ac.ma'; // Your SMTP email address
        $mail->Password = 'F136401894@#cat>fich'; // Your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipient
        $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD'); // Your email address and name
        $mail->addAddress($clientEmail); // Recipient email address

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Resent: Verification Code to Recover Your Password';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333;'>
            <h1 style='color: #4169E1;'>Verification Code</h1>
            <p>Hello,</p>
            <p>We have resent your 6-digit verification code. This code is valid for 10 minutes:</p>
            <h1 style='color: red;'>" . $code . "</h1>
            <p>If you did not request this code, please disregard this email.</p>
            <p>Thank you for trusting us,</p>
            <p><strong>The MEDIAHOD Team</strong></p>
            <hr style='border: 0; border-top: 1px solid #ccc;'>
            <p style='font-size: 0.9em; color: #555;'>This email was generated automatically. Please do not reply directly to this email.</p>
        </div>
    ";

        // Send email
        $mail->send();
        echo 'Resent verification email successfully sent to ' . $clientEmail;
    } catch (Exception $e) {
        echo 'Error sending resent verification email: ' . $mail->ErrorInfo;
    }
}


function send_email_validation($detailsCommand, $detailsUser, $detailsAccounts = null, $file = null) {
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wafik.red.fst@uhp.ac.ma';
        $mail->Password = 'F136401894@#cat>fich';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD');
        $mail->addAddress($detailsUser['email']); // L'adresse email de l'utilisateur

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Your Order Confirmation';

        // Début du corps de l'email
        $emailBody = "
            <h2>Order Confirmation</h2>
            <p>Dear {$detailsUser['username']},</p>
            <p>We are pleased to inform you that your order placed on <strong>{$detailsCommand['dateCom']}</strong> has been successfully confirmed.</p>
            <h3>Order Details:</h3>
            <ul>
                <li><strong>Product:</strong> {$detailsCommand['productName']}</li>
                <li><strong>Quantity:</strong> {$detailsCommand['quantite']}</li>
                <li><strong>Total Amount:</strong> {$detailsCommand['montant']} $</li>
            </ul>";

        // Gestion des comptes achetés
        if (!is_null($detailsAccounts)) {
            $emailBody .= "
            <h3>Purchased Accounts:</h3>
            <div>{$detailsAccounts}</div>";
        }

        // Ajout d'une mention si un fichier est fourni
        if (!is_null($file) && isset($file['tmp_name']) && file_exists($file['tmp_name'])) {
            $emailBody .= "<p>The account details are provided in the attached file.</p>";
            // Attacher le fichier
            $mail->addAttachment($file['tmp_name'], $file['name']);
        }

        // Fin du corps de l'email
        $emailBody .= "
            <p>Your wallet now contains <strong>{$detailsUser['wallet']} $</strong> after this purchase.</p>
            <p>Thank you for your trust in MEDIAHOD.</p>
        ";

        $mail->Body = $emailBody;

        // Envoi de l'email
        $mail->send();
        echo "Email has been sent successfully";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}





function send_email_annulation($detailsCommand, $detailsUser) {
    $mail = new PHPMailer(true);

    try {
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'wafik.red.fst@uhp.ac.ma'; 
        $mail->Password = 'F136401894@#cat>fich'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('wafik.red.fst@uhp.ac.ma', 'MEDIAHOD'); 
        $mail->addAddress($detailsUser['email']); 

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = 'Order Cancellation Notice';

        // Contenu du corps de l'email avec les raisons d'annulation
        $mail->Body = "
            <p>Dear {$detailsUser['username']},</p>
            <p>We regret to inform you that your order with the following details has been cancelled:</p>
            <ul>
                <li><strong>Order ID:</strong> {$detailsCommand['idCom']}</li>
                <li><strong>Date:</strong> {$detailsCommand['dateCom']}</li>
                <li><strong>Product:</strong> {$detailsCommand['productName']}</li>
                <li><strong>Quantity:</strong> {$detailsCommand['quantite']}</li>
                <li><strong>Total Amount:</strong> {$detailsCommand['montant']} $</li>
            </ul>
            <p>The cancellation may have occurred due to one of the following reasons:</p>
            <ul>
                <li>Insufficient stock for the product you ordered, as a previous order has been placed before yours.</li>
                <li>A possible typographical error during order processing.</li>
            </ul>
            <p>If you believe this is an error, please <a href='http://localhost/acc/views/contactUs/contactUs.php'>contact us</a>.</p>
            <p>Best regards,</p>
            <p>MEDIAHOD Team</p>
        ";

        // Envoi de l'email
        $mail->send();
        echo 'Cancellation email has been sent successfully.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
