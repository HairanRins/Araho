<?php
session_start();

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "goals";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer l'ID de l'utilisateur à partir de la session
$userId = $_SESSION['user_id'];

$sql = "SELECT id, category, color, content FROM notes WHERE user_id = '$userId'";
$result = $conn->query($sql);

$notes = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}

echo json_encode($notes);

$conn->close();

?>
