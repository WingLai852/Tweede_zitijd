<?php
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/List.php';
require_once __DIR__ . '/classes/Task.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['list_name'])) {
        $list_name = $_POST['list_name'];
        
        try {
            $list = new taskList($user_id, $list_name);
            if ($list->save()) {
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Er is iets misgegaan bij het toevoegen van de lijst.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } elseif (isset($_POST['task_title'])) {
        $list_id = $_POST['list_id'];
        $task_title = $_POST['task_title'];
        $deadline = $_POST['deadline'];
        
        try {
            $task = new Task($list_id, $task_title, $deadline);
            if ($task->save()) {
                header('Location: dashboard.php');
                exit();
            } else {
                echo "Er is iets misgegaan bij het toevoegen van de taak.";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

$lists = taskList::getAllByUserId($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lijst en Taak Toevoegen</title>
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
        input[type="text"],
        input[type="date"],
        select {
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
        .form-section {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lijst en Taak Toevoegen</h1>

        <!-- Formulier voor het toevoegen van een nieuwe lijst -->
        <div class="form-section">
            <h2>Nieuwe Lijst Toevoegen</h2>
            <form action="add_list.php" method="post">
                <div>
                    <label for="list_name">Lijstnaam:</label>
                    <input type="text" id="list_name" name="list_name" required>
                </div>
                <button type="submit">Lijst Toevoegen</button>
            </form>
        </div>

        <!-- Formulier voor het toevoegen van een nieuwe taak aan een specifieke lijst -->
        <div class="form-section">
            <h2>Nieuwe Taak Toevoegen</h2>
            <form action="add_list.php" method="post">
                <div>
                    <label for="list_id">Lijst:</label>
                    <select id="list_id" name="list_id" required>
                        <?php foreach ($lists as $list): ?>
                            <option value="<?php echo $list['id']; ?>"><?php echo htmlspecialchars($list['taak']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="task_title">Titel:</label>
                    <input type="text" id="task_title" name="task_title" required>
                </div>
                <div>
                    <label for="deadline">Deadline:</label>
                    <input type="date" id="deadline" name="deadline">
                </div>
                <button type="submit">Taak Toevoegen</button>
            </form>
        </div>
    </div>
</body>
</html>
