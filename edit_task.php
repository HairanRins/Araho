<?php
$mysqli = new mysqli("localhost", "username", "password", "task_management");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$status = $_POST['status'];
$priority = $_POST['priority'];
$name = $_POST['name'];
$description = $_POST['description'];
$due_date = $_POST['due_date'];
$id = intval($_POST['id']);
$userId = intval($_POST['user_id']);

$stmt = $mysqli->prepare("UPDATE manage SET status = ?, priority = ?, name = ?, description = ?, due_date = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("ssssssi", $status, $priority, $name, $description, $due_date, $id, $userId);

if ($stmt->execute()) {
    header('Location: dashboard.php?id=' . $userId);
} else {
    echo "Error updating record: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form method="POST" action="edit_task.php">
        <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <input type="hidden" name="user_id" value="<?= $userId ?>">
        <label>Status:</label>
        <select name="status">
            <option value="Ouvert" <?= $task['status'] == 'Ouvert' ? 'selected' : '' ?>>Ouvert</option>
            <option value="Complet" <?= $task['status'] == 'Complet' ? 'selected' : '' ?>>Complet</option>
            <option value="Annule" <?= $task['status'] == 'Annule' ? 'selected' : '' ?>>Annule</option>
        </select>
        <label>Priority:</label>
        <select name="priority">
            <option value="Faible" <?= $task['priority'] == 'Faible' ? 'selected' : '' ?>>Faible</option>
            <option value="Moyen" <?= $task['priority'] == 'Moyen' ? 'selected' : '' ?>>Moyen</option>
            <option value="Important" <?= $task['priority'] == 'Important' ? 'selected' : '' ?>>Important</option>
        </select>
        <label>Name:</label>
        <input type="text" name="name" value="<?= $task['name'] ?>" required>
        <label>Description:</label>
        <textarea name="description" required><?= $task['description'] ?></textarea>
        <label>Due Date:</label>
        <input type="date" name="due_date" value="<?= $task['due_date'] ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
