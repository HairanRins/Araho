<?php
$mysqli = new mysqli("localhost", "username", "password", "task_management");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = intval($_GET['id']);
$userId = intval($_GET['user_id']);

$stmt = $mysqli->prepare("SELECT * FROM manage WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);
$stmt->execute();
$result = $stmt->get_result();

$task = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($task);

$stmt->close();
$mysqli->close();
?>
