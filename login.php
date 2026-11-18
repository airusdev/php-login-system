<?php
require_once 'db.php';
session_start();

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

        header('Location: index.php');
        exit;
    }

    // step 2: look up if username exists
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $stmt = mysqli_prepare($conn, "SELECT * FROM `users` WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    // step 3: if username exists, password_verify
    if ($user) {
        if (password_verify($pass, $user['password'])) {
            // step 4: if password_verify matches, let user proceed to the dashboard
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['user_id'];
            header('Location: dashboard.php');
            exit;
        }
    }

    //step 5: else invalid username or password
    $errors['invalid_info'] = 'Invalid username or password.';
    $_SESSION['errors'] = $errors;

    header('Location: index.php');
    exit;
}
?>
