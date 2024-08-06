<?php
require_once __DIR__ . '/classes/comments.php';

if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    $commentObj = new Comment();
    $comments = $commentObj->getCommentsByTaskId($task_id);

    foreach ($comments as $comment) {
        echo '<div class="comment"><strong>' . htmlspecialchars($comment['username']) . ':</strong> ' . htmlspecialchars($comment['comment']) . '</div>';
    }
}
?>

