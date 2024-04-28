<?php
// Include database connection
require_once 'db.php';

// Check if the task ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish_task'])) {
    $taskId = $_POST['finish_task'];

    // Prepare an SQL statement to update the task's status to finished
    $stmt = $pdo->prepare('UPDATE tasks SET status = "finished" WHERE id = :id');
    $stmt->execute(['id' => $taskId]);
}

// Redirect back to the main page
header('Location: index.php');
exit;
?>
