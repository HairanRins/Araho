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
$userId = intval($_POST['user_id']); // Assurez-vous que l'ID utilisateur est bien reçu

$stmt = $mysqli->prepare("INSERT INTO manage (status, priority, name, description, due_date, user_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $status, $priority, $name, $description, $due_date, $userId);

if ($stmt->execute()) {
    header('Location: dashboard.php?id=' . $userId);
} else {
    echo "Error: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>

