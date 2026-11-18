<?php 
session_start();

$messages = [];
$_SESSION = [];

$params = session_get_cookie_params();
setcookie(
    session_name(),
    '',
    time() - 42000,
    $params['path'],
    $params['domain'],
    $params['secure'],
    $params['httponly']
);

session_regenerate_id(true);

$messages['successful_logout'] = "You have been logged out successfully.";
$_SESSION['messages'] = $messages;

header('Location: index.php');
exit;
?>
