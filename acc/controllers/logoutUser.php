<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['isConnected']);
$_SESSION['MessageS'] = 'You have been successfully disconnected.';
header('Location: ../views/home/home.php');
?>