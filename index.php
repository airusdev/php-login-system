<?php

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
        <form class="form active" id="login" method="POST" action="">
            <label for="login-username">Username</label>
            <input type="text" id="login-username" name="username" placeholder="Enter your username" required>

            <label for="login-password">Password</label>
            <input type="password" id="login-password" name="password" placeholder="••••••••" required>

            <button type="submit">Login</button>
        </form>

        <!-- Register Form -->
        <form class="form" id="register" method="POST" action="">
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