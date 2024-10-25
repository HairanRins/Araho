<?php
$mysqli = new mysqli("localhost", "username", "password", "task_management");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = intval($_GET['id']);
$userId = intval($_GET['user_id']);

$stmt = $mysqli->prepare("DELETE FROM manage WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);

if ($stmt->execute()) {
    header('Location: dashboard.php?id=' . $userId);
} else {
    echo "Error deleting record: " . $mysqli->error;
}

$stmt->close();
$mysqli->close();
?>
