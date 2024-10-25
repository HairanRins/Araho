<?php
$servername = "localhost";
$username = "root"; // Changez ceci si vous avez un autre nom d'utilisateur
$password = ""; // Changez ceci si vous avez un mot de passe
$dbname = "goals";

// Créez une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$goalName = $_POST['goalName'];
$goalType = $_POST['goalType'];
$tasks = json_encode($_POST['tasks']);

$sql = "INSERT INTO goals (name, type, tasks) VALUES ('$goalName', '$goalType', '$tasks')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
