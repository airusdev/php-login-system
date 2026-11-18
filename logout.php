<?php 
session_start();
$messages = [];

unset($_SESSION['user_id']);
$messages['successful_logout'] = "You have been logged out successfully.";
$_SESSION['messages'] = $messages;

header('Location: index.php');
exit;
?>