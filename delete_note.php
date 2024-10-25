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

$userId = $_SESSION['user_id'];
$noteId = $_GET['id'];

$sql = "DELETE FROM notes WHERE id = '$noteId' AND user_id = '$userId'";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "error";
}

$conn->close();

?>
