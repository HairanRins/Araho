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

$category = $_POST['category'];
$color = $_POST['color'];
$content = $_POST['content'];

// Validation des valeurs autorisées pour la catégorie et la couleur
$valid_categories = ['Principal', 'Idea', 'Croissance'];
$valid_colors = ['jaune', 'vert', 'rouge', 'bleu', 'violet'];

if (!in_array($category, $valid_categories) || !in_array($color, $valid_colors)) {
    die("Invalid category or color value");
}

// Échappement des données pour éviter les injections SQL
$category = $conn->real_escape_string($category);
$color = $conn->real_escape_string($color);
$content = $conn->real_escape_string($content);

$sql = "INSERT INTO notes (user_id, category, color, content) VALUES ('$userId', '$category', '$color', '$content')";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php?id=".$userId);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
