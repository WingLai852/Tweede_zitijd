<?php
require_once __DIR__.'/classes/user.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    if ($user->register($username, $password)){
        echo 'Gebruiker geregistreerd';
    } else {
        echo 'Er is iets misgegaan';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registratie</title>
</head>
<body>
    <form action="register.php" method="post">
        <div>
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Registreren</button>
    </form>
</body>
</html>