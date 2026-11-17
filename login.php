<?php
require_once 'db.php';
session_start();

// var_dump($_SERVER['REQUEST_METHOD']);
// var_dump($_POST);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // step 1: check if fields are empty
    if ($user == '') {
        $errors['username'] = 'Please enter your username.';
    } if ($pass == '') {
        $errors['password'] = 'Please enter your password.';
    }

    if (!empty($errors)) {
        unset($_POST['password']);

        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;

        // echo "Validation failed. Redirecting...";
        // exit;
        
        header('Location: index.php');
        exit;
    }

    // step 2: look up if username exists

    // step 3: if username exists, password_verify

    // step 4: if password_verify matches, let user proceed to the dashboard

    // step 5: else 'Invalid username or password'
}
?>
