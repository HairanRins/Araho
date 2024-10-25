<?php
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "access";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM users"; // Remplacez "users" par le nom de votre table utilisateur
$result = $conn->query($sql);

$userIds = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $userIds[] = $row['id'];
    }
}

$conn->close();

?>
