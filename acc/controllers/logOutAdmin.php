<?php
session_start();
unset($_SESSION['admin_logged_in']);
$_SESSION['MessageS'] = 'You have been successfully disconnected.';
header('Location: ../views/admin/connexion/login.php');
?>