<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST['email'];
    $subject = "Reply to your message";
    $message = $_POST['reply_message'];
    $headers = "From: admin@example.com"; // Replace with your admin email address

    if (mail($to, $subject, $message, $headers)) {
        echo "Retour envoyé avec succès!";
    } else {
        echo "Impossible d'envoyer le retour";
    }
}
?>
