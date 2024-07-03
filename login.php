<?php
require_once __DIR__.'/classes/user.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    if ($user->login($username, $password)){
        echo 'Gebruiker ingelogd';
    } else {
        echo 'ongeldige gebruikersnaam of wachtwoord';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inloggen</title>
</head>
<body>
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
</body>
</html>