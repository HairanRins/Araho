<?php
session_start();

if (isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']);

    $conn = new mysqli('localhost', 'root', '', 'access');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        echo 'User deleted successfully.';
        header('index.php');
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo '';
}
?>
