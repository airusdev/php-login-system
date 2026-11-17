<?php
session_start();

// var_dump($_SERVER['REQUEST_URI']);
// var_dump($_SESSION['errors'] ?? []);
// exit;

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// var_dump($_SESSION['errors']);
// exit;

unset($_SESSION['errors']);
unset($_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login / Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 380px;
        }

        .tabs {
            display: flex;
            margin-bottom: 28px;
            border-bottom: 2px solid #e8e8e8;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #888;
            transition: color 0.2s;
        }

        .tab.active {
            color: #4f46e5;
            border-bottom: 2px solid #4f46e5;
            margin-bottom: -2px;
        }

        .form { display: none; }
        .form.active { display: block; }
        
        /* Turns the input border red when there is an error */
        .form input.input-error {
            border: 1.5px solid #d93025;
            background-color: #fffafa;
            margin-bottom: 4px;
        }

        .form input.input-error:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(217, 48, 37, 0.15);
        }

        /* Clean, modern red error text + icon */
        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0 0 12px; /* Adjust 12px to match your normal input margin-bottom */
            color: #d93025;
            font-size: 0.8125rem;
            font-weight: 500;
            line-height: 1.4;
        }

        .error-message svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 18px;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #4f46e5;
        }

        button {
            width: 100%;
            padding: 11px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>

    <div class="card">

        <div class="tabs">
            <div class="tab active" onclick="switchTab('login', this)">Login</div>
            <div class="tab" onclick="switchTab('register', this)">Register</div>
        </div>

<!-- Login Form -->
        <form class="form active" id="login" method="POST" action="login.php">
            <label for="login-username">Username</label>
            <input 
                type="text" 
                id="login-username" 
                name="username" 
                placeholder="Enter your username"
                class="<?= isset($errors['username']) ? 'input-error' : '' ?>"
            >
            <?php if (isset($errors['username'])): ?>
                <p class="error-message">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['username']) ?></span>
                </p>
            <?php endif; ?>

            <label for="login-password">Password</label>
            <input 
                type="password" 
                id="login-password" 
                name="password" 
                placeholder="••••••••"
                class="<?= isset($errors['password']) ? 'input-error' : '' ?>"
            >
            <?php if (isset($errors['password'])): ?>
                <p class="error-message">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['password']) ?></span>
                </p>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>

        <!-- Register Form -->
        <form class="form" id="register" method="POST" action="/register.php">
            <label for="reg-username">Username</label>
            <input type="text" id="reg-username" name="username" placeholder="Choose a username" required>

            <label for="reg-password">Password</label>
            <input type="password" id="reg-password" name="password" placeholder="••••••••" required>

            <button type="submit">Create Account</button>
        </form>

    </div>

    <script>
        function switchTab(formId, clickedTab) {
            document.querySelectorAll('.form').forEach(f => f.classList.remove('active'));
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById(formId).classList.add('active');
            clickedTab.classList.add('active');
        }
    </script>

</body>
</html>