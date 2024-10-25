<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $profileImage = $_FILES['profile_image'];
    $uploadDir = 'img/';
    
    // Ensure the passwords match
    if ($password !== $confirmPassword) {
        echo 'Passwords do not match.';
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $uploadFile = $uploadDir . basename($profileImage['name']);

    // Move the uploaded file
    if (move_uploaded_file($profileImage['tmp_name'], $uploadFile)) {
        // Save user data in the database
        $conn = new mysqli('localhost', 'root', '', 'access');

        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        $stmt = $conn->prepare('INSERT INTO users (name, email, password, profile_image) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $email, $hashedPassword, $profileImage['name']);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id; // Save the user ID in the session
            // Redirect to login page
            header('Location: login.php');
            exit;
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo 'Failed to upload image.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/cocas.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h2>Inscription</h2>
    <form action="register.php" method="POST" enctype="multipart/form-data">
        <div class="group">
        <i class="fas fa-user"></i>
        <input placeholder="Nom" type="text" id="name" name="name" required><br>
        </div>
        <div class="group">
        <i class="fas fa-envelope"></i>
        <input  placeholder="Email" type="email" id="email" name="email" required><br>
        </div>
        <div class="group">
            <div class="password-container">
                <i class="fas fa-lock"></i>
                <input  placeholder="Mot de passe" type="password" id="password" name="password" required><br>
                <span id="toggle-password" class="fa fa-eye"></span>
            </div>
        </div>
        <div class="group">
            <div class="password-container">
                <i class="fas fa-lock"></i>
                <input  placeholder="Confirmation de mot de passe" type="password" id="confirm_password" name="confirm_password" required><br>
                <span id="toggle-confirm-password" class="fa fa-eye"></span>
            </div>
        </div>
        <label for="profile_image">Profile Image:</label>
        <input type="file" id="profile_image" name="profile_image" accept="image/*" required><br>
        <i class="fas fa-image upload-icon"></i>

        <input type="submit" value="S'inscrire" class="submit-valid">
    </form>
    </div>
<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm_password').value;
    
        if (password !== confirmPassword) {
        alert('Passwords do not match.');
        event.preventDefault();
        }

        let profileImage = document.getElementById('profile_image').value;
        if (profileImage.trim() === '') {
        alert('Please provide a valid image URL.');
        event.preventDefault();
        }
    });
    document.querySelector('.upload-icon').addEventListener('click', function() {
        document.getElementById('profile_image').click();
    });
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
    document.getElementById('toggle-confirm-password').addEventListener('click', function () {
        const confirmPasswordField = document.getElementById('confirm_password');
        const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
});
    </script>
</body>
</html>
