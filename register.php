<?php
require_once 'db.php';
session_start();

$messages = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['reg_username']);
    $pass = $_POST['reg_password'];
    $reenter_pass = $_POST['reg_reenter_password'];

    // step 1: check if fields are empty
    if ($user == '') {
        $errors['reg_username'] = 'Please enter a username.';
    } if ($pass == '') {
        $errors['reg_password'] = 'Please enter a password.';
    } if ($reenter_pass == '') {
        $errors['reg_reenter_password'] = 'Please reenter your password.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }

    // step 2: check if username is valid
    if (!preg_match('/^(?=.{3,16}$)[a-zA-Z][a-zA-Z0-9_]*[a-zA-Z]$/', $user)) {
        $errors['reg_username'] = 'Invalid username.';
    }

    // step 3: check consecutive underscores
    if (preg_match('/__/', $user)) {
        $errors['reg_username'] = 'No consecutive underscores';
    }

    // step 4: check if both passwords match
    if ($pass != $reenter_pass) {
        $errors['reg_password'] = 'Please make sure both passwords match.';
        $errors['reg_reenter_password'] = 'Please make sure both passwords match.';
    }

    // step 5: check if valid length
    $length = mb_strlen($pass);
    if ($length < 8 || $length > 256) {
        $errors['reg_invalid_length'] = 'Password length must be greater than 8 but less than 256.';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }

    // step 6: look up if username exists
    $stmt = mysqli_prepare($conn, "SELECT * FROM `users` WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $checked_user = mysqli_fetch_assoc($result);

    // step 7: if username exists, warn user
    if ($checked_user) {
        $errors['reg_username'] = 'This username is unavailable. Please choose another username';
        $_SESSION['errors'] = $errors;

        header('Location: index.php');
        exit;
    }
    
    try {
        // step 8: successful registration
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "INSERT INTO `users` (`username`, `password`) VALUES (?, ?)");

        mysqli_stmt_bind_param($stmt, "ss", $user, $hashed_password);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $messages['successful_reg_message'] = 'Your account has been created successfully!';
            $_SESSION['messages'] = $messages;

            header('Location: index.php');
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        // step 9: catch mysql insert errors
        $errors['reg_unsuccessful_insert'] = 'Registration failed. Please try again.';
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }
}
?>