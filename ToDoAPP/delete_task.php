<?php
// Include database connection
require_once 'db.php';

// Check if the task ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task'])) {
    $taskId = $_POST['delete_task'];

    // Prepare an SQL statement to delete the task
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->execute(['id' => $taskId]);
}

// Redirect back to the main page
header('Location: index.php');
exit;
?>
