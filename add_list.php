<?php
require_once __DIR__ . '/classes/list.php';
require_once __DIR__ . '/classes/user.php'; 
session_start();


if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $taak = $_POST['taak'];
    $user_id = $_SESSION['user_id'];


    try{
    $list = new taskList($user_id, $taak);
    if($list->save()){
        header('Location: dashboard.php');
    } else {
        echo 'Er is iets misgegaan';
    }
}
catch(Exception $e){
    echo $e->getMessage();
}
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Lijst Toevoegen</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lijst Toevoegen</h1>
        <form action="add_list.php" method="post">
            <div>
                <label for="taak">Lijstnaam:</label>
                <input type="text" id="taak" name="taak" required>
            </div>
            <button type="submit">Toevoegen</button>
        </form>
    </div>
</body>
</html>