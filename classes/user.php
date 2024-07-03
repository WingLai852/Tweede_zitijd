<?php
require_once __DIR__ . '/../config.php';

class User {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->pdo;
    }

    public function register($username, $password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashed_password]);
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && isset($user['password'])) {
            if (password_verify($password, $user['password'])) {
                return $user;
            } else {
                echo "Wachtwoordverificatie mislukt";
            }
        } else {
            echo "Gebruiker niet gevonden of wachtwoord is null";
        }

        return false;
    }
}
?>
