<?php
require_once __DIR__ . '/classes/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $loggedInUser = $user->login($username, $password);
  if ($loggedInUser) {
    session_start();
    $_SESSION['user_id'] = $loggedInUser['id'];
    header('Location: dashboard.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inloggen</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }

        .register-button {
            background-color: #008CBA;
            margin-top: 20px;  
        }
        .register-button:hover {
            background-color: #007BB5;
        }
        .note {
            text-align: center;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inloggen</h1>
        <form action="login.php" method="post">
            <div>
                <label for="username">Gebruikersnaam:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Inloggen</button>
        </form>
        <button onclick="window.location.href='register.php'" class="register-button">Nog geen account? Registreer hier</button>
        <div class="note">Welkom terug! Log in om verder te gaan.</div>
    </div>
</body>
</html>
