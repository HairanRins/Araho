<?php
session_start();

$userId = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'access');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Obtenir les informations actuelles de l'utilisateur
$stmt = $conn->prepare('SELECT name, email, profile_image FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $profileImage);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $newProfileImage = $_FILES['profile_image'];
    $uploadDir = 'img/';
    $uploadFile = $profileImage; // Conserver l'image actuelle par défaut

    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    } else {
        $hashedPassword = null; // Pas de changement de mot de passe
    }

    if ($newProfileImage['size'] > 0) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadFile = $uploadDir . basename($newProfileImage['name']);
        if (!move_uploaded_file($newProfileImage['tmp_name'], $uploadFile)) {
            echo 'Failed to upload image.';
            exit;
        }
    }

    $updateStmt = $conn->prepare('UPDATE users SET name = ?, email = ?, profile_image = ?' . ($hashedPassword ? ', password = ?' : '') . ' WHERE id = ?');
    
    if ($hashedPassword) {
        $updateStmt->bind_param('ssssi', $newName, $newEmail, $newProfileImage['name'], $hashedPassword, $userId);
    } else {
        $updateStmt->bind_param('sssi', $newName, $newEmail, $newProfileImage['name'], $userId);
    }

    if ($updateStmt->execute()) {
        header('Location: dashboard.php?id=' . $userId);
    } else {
        echo 'Error: ' . $updateStmt->error;
    }

    $updateStmt->close();
}

$conn->close();
?>

