<?php
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/List.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taak = $_POST['taak'];
    $user_id = $_SESSION['user_id'];

    if (taskList::deleteByName($user_id, $taak)) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Er is een fout opgetreden";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lijst Verwijderen</title>
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
        <h1>Lijst Verwijderen</h1>
        <form action="delete_list.php" method="post">
            <div>
                <label for="taak">Lijstnaam:</label>
                <input type="text" id="taak" name="taak" required>
            </div>
            <button type="submit">Verwijderen</button>
        </form>
    </div>
</body>
</html>
