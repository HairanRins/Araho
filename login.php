<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'access');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $hashedPassword);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashedPassword)) {
        // Set session and redirect to profile with user ID in URL
        $_SESSION['user_id'] = $userId;
        header('Location: dashboard.php?id=' . $userId);
        exit;
    } else {
        echo 'Invalid email or password.';
    }

    $stmt->close();
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="CSS/connex.css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
    <h2>Connexion</h2>
    <form action="login.php" method="POST" class="form">
        <div class="group">
            <i class="fas fa-envelope"></i>
            <input placeholder="Email" type="email" id="email" name="email" required>
        </div>
        <div class="group">
            <div class="password-container">
                <span id="toggle-password" class="fa fa-eye"></span>
                <input placeholder="Mot de passe" type="password" id="password" name="password" required>
            </div>
        </div>
        <input type="submit" value="Se connecter" class="submit-valid">
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Inscription</a></p>
    </div>
    <script>
        function affmdp() {
            let aff_mdp = document.querySelector(".mdp")
            if (aff_mdp.type === 'password') {
                aff_mdp.type = 'text';
            } else {
                aff_mdp.type = 'password';
            }
        }
        document.getElementById('toggle-password').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});

    </script>
</body>
</html>

