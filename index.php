<?php
session_start();

$messages = $_SESSION['messages'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['messages']);
unset($_SESSION['errors']);
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

        .form input.input-error {
            border: 1.5px solid #d93025;
            background-color: #fffafa;
            margin-bottom: 4px;
        }

        .form input.input-error:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(217, 48, 37, 0.15);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0 0 12px;
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

        .error-message + .input-hint {
            margin-top: -4px;
        }

        .alert-error {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding: 10px 12px;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            color: #d93025;
            font-size: 0.8125rem;
            font-weight: 500;
            line-height: 1.4;
        }

        .alert-error svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .alert-success {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
            padding: 10px 12px;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            color: #15803d;
            font-size: 0.8125rem;
            font-weight: 500;
            line-height: 1.4;
        }

        .alert-success svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        input.has-hint {
            margin-bottom: 6px;
        }

        .input-hint {
            list-style: none;
            margin: 0 0 18px;
            padding: 8px 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }

        .input-hint li {
            position: relative;
            padding-left: 12px;
        }

        .input-hint li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #94a3b8;
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
        <?php
            $reg_is_active = (isset($errors['reg_username']) || isset($errors['reg_password']) || isset($errors['reg_reenter_password']));
        ?>

        <div class="tabs">
            <div class="<?= !$reg_is_active ? 'tab active' : 'tab'?>" onclick="switchTab('login', this)">Login</div>
            <div class="<?= $reg_is_active ? 'tab active' : 'tab'?>" onclick="switchTab('register', this)">Register</div>
        </div>

        <!-- Login Form -->
        <form class="<?= !$reg_is_active ? 'form active' : 'form'?>" id="login" method="POST" action="login.php">
            <label for="login-username">Username</label>
            <input
                type="text"
                id="login-username"
                name="username"
                placeholder="Enter your username"
                class="<?= isset($errors['username']) ? 'input-error' : '' ?>"
            >

            <!-- username is required warning error -->
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

            <!-- password is required warning error -->
            <?php if (isset($errors['password'])): ?>
                <p class="error-message">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['password']) ?></span>
                </p>
            <?php endif; ?>

            <button type="submit">Login</button>

            <!-- invalid username or password warning error -->
            <?php if (isset($errors['invalid_info'])): ?>
                <div class="alert-error" role="alert">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['invalid_info']) ?></span>
                </div>
            <?php endif; ?>

            <!-- successful registration message -->
            <?php if (isset($messages['successful_reg_message'])): ?>
                <div class="alert-success" role="status">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.22 5.28-3.75 3.75a.75.75 0 0 1-1.06 0L4.78 8.4a.75.75 0 0 1 1.06-1.06l1.1 1.1 3.22-3.22a.75.75 0 1 1 1.06 1.06z"/>
                    </svg>
                    <span><?= htmlspecialchars($messages['successful_reg_message']) ?></span>
                </div>
            <?php endif; ?>
            
            <!-- successful logout message -->
            <?php if (isset($messages['successful_logout'])): ?>
                <div class="alert-success" role="status">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.22 5.28-3.75 3.75a.75.75 0 0 1-1.06 0L4.78 8.4a.75.75 0 0 1 1.06-1.06l1.1 1.1 3.22-3.22a.75.75 0 1 1 1.06 1.06z"/>
                    </svg>
                    <span><?= htmlspecialchars($messages['successful_logout']) ?></span>
                </div>
            <?php endif; ?>

            <!-- user unauthenticated error message -->
            <?php if (isset($errors['is_unauthenticated'])): ?>
                <div class="alert-error" role="alert">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['is_unauthenticated']) ?></span>
                </div>
            <?php endif; ?>
        </form>

        <!-- Register Form -->
        <form class="<?= $reg_is_active ? 'form active' : 'form'?>" id="register" method="POST" action="register.php">
            <label for="reg-username">Username</label>
            <input
                type="text"
                id="reg-username"
                name="reg_username"
                placeholder="Choose a username"
                class="has-hint <?= isset($errors['reg_username']) ? 'input-error' : '' ?>"
            >

            <?php if (isset($errors['reg_username'])): ?>
                <p class="error-message">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['reg_username']) ?></span>
                </p>
            <?php endif; ?>

            <ul class="input-hint">
                <li>3–16 characters long</li>
                <li>Must start and end with a letter (a–z, A–Z)</li>
                <li>Only letters, numbers, and underscores (_)</li>
                <li>Cannot end with an underscore or use consecutive underscores (__)</li>
            </ul>

            <label for="reg-password">Password</label>
            <input
                type="password"
                id="reg-password"
                name="reg_password"
                placeholder="••••••••"
                class="<?= isset($errors['reg_password']) ? 'input-error' : '' ?>"
            >

            <?php if (isset($errors['reg_password'])): ?>
                <p class="error-message">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['reg_password']) ?></span>
                </p>
            <?php endif; ?>

            <label for="reg-reenter-password">Re-enter Password</label>
            <input
                type="password"
                id="reg-reenter-password"
                name="reg_reenter_password"
                placeholder="••••••••"
                class="<?= isset($errors['reg_reenter_password']) ? 'input-error' : '' ?>"
            >

            <?php if (isset($errors['reg_reenter_password'])): ?>
                <p class="error-message">
                    <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                        <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 10.5a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5zM8.75 8a.75.75 0 0 1-1.5 0V4.75a.75.75 0 0 1 1.5 0V8z"/>
                    </svg>
                    <span><?= htmlspecialchars($errors['reg_reenter_password']) ?></span>
                </p>
            <?php endif; ?>

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