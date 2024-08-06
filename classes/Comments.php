<?php
require_once __DIR__ . '/../config.php';

class Comment {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->pdo;
    }

    public function addComment($task_id, $user_id, $comment) {
        $stmt = $this->pdo->prepare('INSERT INTO Commentaren (task_id, user_id, comment) VALUES (?, ?, ?)');
        return $stmt->execute([$task_id, $user_id, $comment]);
    }

    public static function getCommentsByTaskId($task_id) {
        $database = new Database();
        $pdo = $database->pdo;
        $stmt = $pdo->prepare('SELECT c.*, u.username FROM Commentaren c JOIN users u ON c.user_id = u.id WHERE c.task_id = ? ORDER BY c.created_at DESC');
        $stmt->execute([$task_id]);
        return $stmt->fetchAll();
    }
}
?>