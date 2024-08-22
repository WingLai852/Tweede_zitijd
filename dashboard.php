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
    if (isset($_POST['delete_task'])) {
        $task_id = $_POST['task_id'];
        if (Task::deleteById($task_id)) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de taak.";
        }
    } elseif (isset($_POST['delete_list'])) {
        $list_id = $_POST['list_id'];
        if (taskList::deleteById($list_id)) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Er is een fout opgetreden bij het verwijderen van de lijst.";
        }
    }
}

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
        }
        .list:last-child {
            border-bottom: none;
        }
        .task {
            padding: 10px;
            border-bottom: 1px solid #eee;
            margin-left: 20px;
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
        <h2>Jouw ToDo lijsten</h2>
        <?php if ($lists): ?>
            <?php foreach ($lists as $list): ?>
                <div class="list">
                    <span><?php echo htmlspecialchars($list['taak']); ?></span>
                    <form action="dashboard.php" method="post" style="display:inline;">
                        <input type="hidden" name="list_id" value="<?php echo htmlspecialchars($list['id']); ?>">
                        <input type="hidden" name="delete_list" value="1">
                        <button type="submit" class="delete-button">Verwijderen</button>
                    </form>


                    <?php
                    $tasks = Task::getAllByListId($list['id']);
                    if ($tasks): ?>
                        <?php foreach ($tasks as $task): ?>
                            <div class="task">
                                <span><?php echo htmlspecialchars($task['title']); ?></span>
                                <?php if ($task['deadline']): ?>
                                    <span>(<?php echo htmlspecialchars($task['deadline']); ?>)</span>
                                <?php endif; ?>
                                <form action="dashboard.php" method="post" style="display:inline;">
                                    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                                    <input type="hidden" name="delete_task" value="1">
                                    <button type="submit" class="delete-button">Verwijderen</button>
                                </form>
                                <!-- Comment sectie -->
                                <form action="dashboard.php" method="post" class="comment-form" data-task-id="<?php echo htmlspecialchars($task['id']); ?>">
    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
    <textarea name="comment" id="comment-<?php echo $task['id']; ?>" rows="2" cols="50" placeholder="Voeg een commentaar toe"></textarea>
    <button type="submit" class="comment-button">Comment</button>
</form>


                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="task">Geen taken.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Je hebt nog geen lijsten.</p>
        <?php endif; ?>
        <div class="actions">
            <a href="add_list.php"><button>Lijst of Taak Toevoegen</button></a>
        </div>
    </div>
</body>
</html>
