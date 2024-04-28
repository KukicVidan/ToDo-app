<?php
// Include database connection
require_once 'db.php';

// Check if the form was submitted to add a new task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_name'])) {
    $taskName = $_POST['task_name'];

    // Prepare an SQL statement to insert a new task
    $stmt = $pdo->prepare('INSERT INTO tasks (task_name) VALUES (:task_name)');
    $stmt->execute(['task_name' => $taskName]);

    // Redirect to avoid form resubmission
    header('Location: index.php');
    exit;
}

// Check if a task ID was provided to delete a task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taskId = $_POST['delete_task'];

    // Prepare an SQL statement to delete the task
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->execute(['id' => $taskId]);

    // Redirect to avoid resubmitting the delete request
    header('Location: index.php');
    exit;
}

// Check if a task ID was provided to mark a task as finished
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish_task'])) {
    $taskId = $_POST['finish_task'];

    // Prepare an SQL statement to update the task's status to finished
    $stmt = $pdo->prepare('UPDATE tasks SET status = "finished" WHERE id = :id');
    $stmt->execute(['id' => $taskId]);

    // Redirect to avoid resubmitting the finish request
    header('Location: index.php');
    exit;
}

// Fetch all tasks from the database
$stmt = $pdo->query('SELECT * FROM tasks ORDER BY created_at DESC');
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="app-container">
    <h1>To-Do App</h1>
    
    <form action="index.php" method="post" class="task-form">
        <input type="text" name="task_name" placeholder="Enter task" class="task-input">
        <button type="submit" class="add-button">Add Task</button>
    </form>

    <ul class="task-list">
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['task_name']) ?>
                <form action="index.php" method="post" style="display: inline;">
                    <input type="hidden" name="delete_task" value="<?= $task['id'] ?>">
                    <button type="submit" class="delete-button">Delete</button>
                </form>
                <?php if ($task['status'] !== 'finished'): ?>
                    <form action="index.php" method="post" style="display: inline;">
                        <input type="hidden" name="finish_task" value="<?= $task['id'] ?>">
                        <button type="submit" class="finish-button">Finish</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
