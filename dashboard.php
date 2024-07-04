<?php
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/List.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$lists = taskList::getAllByUserId($user_id);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
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
        .list {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
        }
        .list:last-child {
            border-bottom: none;
        }
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 10px;
        }
        button:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: #f44336;
        }
        .delete-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <h2>Jouw ToDo lijst</h2>
        <?php if ($lists): ?>
            <?php foreach ($lists as $list): ?>
                <div class="list">
                    <span><?php echo htmlspecialchars($list['taak']); ?></span>
                    <form action="delete_list.php" method="post" style="display:inline;">
                        <input type="hidden" name="taak" value="<?php echo htmlspecialchars($list['taak']); ?>">
                        <button type="submit" class="delete-button">Verwijderen</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Je hebt nog geen lijsten.</p>
        <?php endif; ?>
        <div class="actions">
            <a href="add_list.php"><button>Lijst Toevoegen</button></a>
        </div>
    </div>
</body>
</html>
