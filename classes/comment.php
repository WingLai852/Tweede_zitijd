<?php
require_once '../config.php';

class Comment {
    private $pdo;

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->pdo;
    }

    public function saveComment($task_id, $user_id, $comment) {
        $stmt = $this->pdo->prepare('INSERT INTO comments (task_id, user_id, comment) VALUES (?, ?, ?)');
        return $stmt->execute([$task_id, $user_id, $comment]);
    }

    public function getCommentsByTaskId($task_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM comments WHERE task_id = ?');
        $stmt->execute([$task_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
