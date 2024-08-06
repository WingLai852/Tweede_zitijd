<?php
require_once __DIR__ . '/classes/comments.php';
session_start();

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['task_id']) && isset($_POST['comment'])) {
            $task_id = $_POST['task_id'];
            $comment = $_POST['comment'];
            $user_id = $_SESSION['user_id'];

            $commentObj = new Comment();
            if ($commentObj->addComment($task_id, $user_id, $comment)) {
                echo json_encode(['success' => true, 'message' => 'Comment added successfully']);
                exit();
            } else {
                throw new Exception('Failed to add comment');
            }
        } else {
            throw new Exception('Invalid input');
        }
    } else {
        throw new Exception('Invalid request');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit();
}
?>
