<?php
require_once __DIR__ . '/../config.php';

class Task {
    private $pdo;

    private $id;
    private $list_id;
    private $title;
    private $deadline;
    private $status;

    public function __construct($list_id, $title, $deadline = null, $status = 'todo') {
        $database = new Database();
        $this->pdo = $database->pdo;

        $this->setListId($list_id);
        $this->setTitle($title);
        if ($deadline) {
            $this->setDeadline($deadline);
        }
        $this->setStatus($status);
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setListId($list_id) {
        if (empty($list_id)) {
            throw new Exception("List ID cannot be empty");
        }
        $this->list_id = $list_id;
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception("Title cannot be empty");
        }
        $this->title = $title;
    }

    public function setDeadline($deadline) {
        $this->deadline = $deadline;
    }
    public function setStatus2($status) {
        $validStatuses = ['todo', 'done'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Invalid status value");
        }
        $this->status = $status;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getListId() {
        return $this->list_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDeadline() {
        return $this->deadline;
    }

    public function setStatus($status) {
        $validStatuses = ['todo', 'done'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Invalid status value");
        }
        $this->status = $status;
    }

    // Database operations
    public function save() {
        $stmt = $this->pdo->prepare('INSERT INTO taken (list_id, title, deadline) VALUES (?, ?, ?)');
        return $stmt->execute([$this->list_id, $this->title, $this->deadline]);
    }

    public static function getAllByListId($list_id) {
        $database = new Database();
        $pdo = $database->pdo;
        $stmt = $pdo->prepare('SELECT id, list_id, title, deadline, status FROM taken WHERE list_id = ?');
        $stmt->execute([$list_id]);
        return $stmt->fetchAll();
    }
    

    public static function deleteById($id) {
        $database = new Database();
        $pdo = $database->pdo;
        $stmt = $pdo->prepare('DELETE FROM taken WHERE id = ?');
        return $stmt->execute([$id]);
    }
    public static function updateStatus($task_id, $status) {
        $validStatuses = ['todo', 'done'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Invalid status value");
        }

        $database = new Database();
        $pdo = $database->pdo;
        $stmt = $pdo->prepare('UPDATE taken SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $task_id]);
    }

}




?>

