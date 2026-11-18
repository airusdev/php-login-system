<?php 
// contains the welcome message and a logout button
require_once 'db.php';
session_start();

$errors = [];

// acquire username
if (!isset($_SESSION['user_id'])) {
    $errors['is_unauthenticated'] = "Please log in to access the dashboard.";
    $_SESSION['errors'] = $errors;
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare('SELECT username from `users` WHERE user_id = ?');
$stmt->bind_param("i", $user_id);
$stmt->execute();

$stmt->bind_result($username);
$stmt->fetch();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: linear-gradient(135deg, #e0e7ff 0%, #f0f2f5 50%, #ede9fe 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.85);
            padding: 48px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 440px;
            text-align: center;
        }

        h1 {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #111827;
            margin-bottom: 28px;
            word-break: break-word;
        }

        .logout-btn {
            display: inline-block;
            padding: 9px 24px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .logout-btn:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>

    <div class="card">
        <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
    </html>