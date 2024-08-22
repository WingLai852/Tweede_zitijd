<?php
require_once '../config.php';
require_once '../classes/comment.php';

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $task_id = $_GET['task_id'];

    $commentObj = new Comment();
    $comments = $commentObj->getCommentsByTaskId($task_id);

    if ($comments) {
        $response['success'] = true;
        $response['comments'] = $comments;
    } else {
        $response['success'] = false;
        $response['message'] = "Geen commentaren gevonden.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Ongeldig verzoek.";
}

echo json_encode($response);
?>
