<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../classes/comment.php';
session_start();

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];  // Zorg ervoor dat de gebruiker is ingelogd

    if (!empty($comment)) {
        $commentObj = new Comment();
        if ($commentObj->saveComment($task_id, $user_id, $comment)) {
            $response['success'] = true;
            $response['comment'] = htmlspecialchars($comment);
        } else {
            $response['success'] = false;
            $response['message'] = "Er is een fout opgetreden bij het opslaan van het commentaar.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Commentaar mag niet leeg zijn.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Ongeldig verzoek.";
}

echo json_encode($response);
?>
