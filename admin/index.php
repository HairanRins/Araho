<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ad.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
<div class="main--content">
    <div class="header--wrapper">
        <div class="header--title">
            <span>Administrateur</span>
            <h2>Tableau de bord</h2>
        </div>
        <div class="user--info">
            <img src="../img/iadmin.png" alt="profil">
        </div>
</div>
</body>
</html>
<?php

include 'dashboard.php';
include 'register.php';
include 'submit_contact_form.php';
include 'send_reply.php';
include 'delete_user.php';


$mysqli = new mysqli("localhost", "username", "password", "task_management");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT COUNT(*) AS total, 
                                 SUM(status = 'Ouvert') AS Ouvert, 
                                 SUM(status = 'Complet') AS Complet, 
                                 SUM(status = 'Annule') AS Annule 
                          FROM manage");
$counts = $result->fetch_assoc();

$result = $mysqli->query("SELECT * FROM manage");
$tasks = $result->fetch_all(MYSQLI_ASSOC);

// $stmt = $mysqli->prepare("SELECT COUNT(*) AS total, 
//                                  SUM(status = 'Ouvert') AS Ouvert, 
//                                  SUM(status = 'Complet') AS Complet, 
//                                  SUM(status = 'Annule') AS Annule 
//                           FROM manage
//                           WHERE user_id = ?");
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result = $stmt->get_result();
// $counts = $result->fetch_assoc();
// $stmt = $mysqli->prepare("SELECT * FROM manage WHERE user_id = ?");
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result = $stmt->get_result();
// $tasks = $result->fetch_all(MYSQLI_ASSOC);


$userId = isset($_GET['id']) ? $_GET['id'] : null;
$_SESSION['user_id'] = $userId;
$userId = intval($_GET['id']);

$result = $mysqli->query("SELECT * FROM manage WHERE user_id = $userId");


$conn = new mysqli('localhost', 'root', '', 'access');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$stmt = $conn->prepare('SELECT name, email, profile_image FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $profileImage);
$stmt->fetch();


$mysqli = new mysqli("localhost", "username", "password", "access");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch submissions
$result1 = $mysqli->query("SELECT * FROM submissions ORDER BY submitted_at DESC");

if ($result1->num_rows > 0) {
    echo "<div class='submiss'>";
    echo "<h2>Les messages soumis</h2>";
    echo "<style>
            .submiss {
                background: #fff;
                border-radius: 10px;
                padding: 10px 2rem;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
                vertical-align: top;
            }
            th {
                background: #3c91e6;
                color: #fff;
                border-color: #3c91e6;
            }
            tr:nth-child(even) {
                background-color: #fff;
            }
            tr:hover {
                background-color: #f1f1f1;
            }
            h2 {
                color: #002855;
                margin-bottom: 10px;
            }
            textarea {
                width: 100%;
                height: 80px;
                padding: 8px;
                margin-top: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                resize:none;
            }
          </style>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Message</th><th>Envoyé à</th><th>Action</th></tr>";

    while ($row = $result1->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "<td>" . $row['submitted_at'] . "</td>";
        echo "<td>";
        echo "<form action='send_reply.php' method='post'>";
        echo "<input type='hidden' name='email' value='" . $row['email'] . "'>";
        echo "<textarea name='reply_message' placeholder='Message à revoyer'></textarea>";
        echo "<button type='submit' class='btn'><i class='fas fa-paper-plane'></i></button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "No submissions found.";
}


// Connexion à la base de données des utilisateurs
$conn = new mysqli('localhost', 'root', '', 'access');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Récupération des informations des utilisateurs
$result2 = $conn->query("SELECT id, name, email, profile_image FROM users");

if ($result2->num_rows > 0) {
    echo "<div class='submiss'>";
    echo "<h2>Liste des utilisateurs</h2>";
    echo "<style>
            .submiss {
                background: #fff;
                border-radius: 10px;
                padding: 10px 2rem;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background: #3c91e6;
                color: #fff;
                border-color: #3c91e6;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tr:hover {
                background-color: #f1f1f1;
            }
            h2 {
                color: #002855;
                margin-bottom: 10px;
            }
            .btn {
                margin-top: 5px;
                margin-left:10px;
                background-color: #0075c9;
                border: 1px solid #0075c9;
                cursor: pointer;
                border-radius: 50%;
                padding: 5px 6px;
                padding-right:7px;
            }
            .btn i {
                font-size:14px;
                margin: 0 auto;
                color: #fff;
            }
            .btn1 {
                border:none;
                background-color: transparent;
                margin-left:15px;
                font-size:16px;
                cursor:pointer;
            }
            .btn1:hover {
                transform:scale(1.1);
            }
          </style>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Profile Image</th><th>Action</th></tr>";
    

    while ($row = $result2->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td><img src='/img/" . $row['profile_image'] . "' alt='Profile Image' width='50'></td>";
        echo "<td>";
        echo "<form action='delete_user.php' method='post' style='display:inline;'>";
        echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' class='btn1' nclick='return confirm(\"Are you sure you want to delete this user?\")'>🗑️</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "No users found.";
}

// Récupérer les utilisateurs
$sql = "SELECT id FROM users";
$result3 = $conn->query($sql);

$userIds = [];
if ($result3->num_rows > 0) {
    // Output data of each row
    while($row = $result3->fetch_assoc()) {
        $userIds[] = $row['id'];
    }
} else {
    echo "0 results";
}

$stmt->close();
$conn->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ad.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.2.1-web/css/all.css">
    <title>Admin</title>
</head>
<body>
<div class="taskss">
<div class="task-countss">
        <div class="task-count total-tasks">
            <i class="fas fa-tasks"></i>
            <p>Total des Tâches: <?= $counts['total'] ?></p>
        </div>
        <div class="task-count open-tasks">
            <i class="fas fa-folder-open"></i>
            <p>Tâches Ouvertes: <?= $counts['Ouvert'] ?></p>
        </div>
        <div class="task-count completed-tasks">
            <i class="fas fa-check-circle"></i>
            <p>Tâches Complétées: <?= $counts['Complet'] ?></p>
        </div>
        <div class="task-count canceled-tasks">
            <i class="fas fa-times-circle"></i>
            <p>Tâches Annulées: <?= $counts['Annule'] ?></p>
        </div>
</div>
<canvas id="pieChart" width="400" height="400"></canvas>
</div>


<div class="objectif">
<h1>Admin Panneau - Objectifs</h1>
<h2>Objectifs ajoutés par les utilisateurs</h2>
<table id="userGoalsTable">
    <thead>
        <tr>
            <th>ID utilisateur</th>
            <th>Nom de l'objectif</th>
            <th>Type d'objectif</th>
            <th>Tâches</th>
        </tr>
    </thead>
    <tbody>
        <!-- Rows will be added here by JS -->
    </tbody>
</table>

<h2 class="obj">Objectifs complétés par les utilisateurs</h2>
<table id="completedGoalsTable">
    <thead>
        <tr>
            <th>ID utilisateur</th>
            <th>Objectif</th>
        </tr>
    </thead>
    <tbody>
        <!-- Rows will be added here by JS -->
    </tbody>
</table>
</div>


        <script src="JS/aply.js"></script>
        <script src="../JS/dash.js"></script>
    <script>
        const userIds = <?php echo json_encode($userIds); ?>;

        // Récupérer les données PHP en JavaScript
    const counts = {
    total: <?= $counts['total'] ?>,
    Ouvert: <?= $counts['Ouvert'] ?>,
    Complet: <?= $counts['Complet'] ?>,
    Annule: <?= $counts['Annule'] ?>
    };
    const canvas = document.getElementById('pieChart');
    const ctx = canvas.getContext('2d');

    const data = [
        {label: 'Ouvert', value: counts.Ouvert, color: '#FF6384'},
        {label: 'Complété(es)', value: counts.Complet, color: '#36A2EB'},
        {label: 'Annulé(es)', value: counts.Annule, color: '#FFCE56'}
    ];

    const total = counts.total;
    let startAngle = 0;

    data.forEach(segment => {
        const sliceAngle = 2 * Math.PI * segment.value / total;
        ctx.beginPath();
        ctx.moveTo(canvas.width / 2, canvas.height / 2);
        ctx.arc(canvas.width / 2, canvas.height / 2, Math.min(canvas.width / 2, canvas.height / 2), startAngle, startAngle + sliceAngle);
        ctx.closePath();
        ctx.fillStyle = segment.color;
        ctx.fill();

        // Ajouter des labels
        const textX = canvas.width / 2 + Math.cos(startAngle + sliceAngle / 2) * (canvas.width / 2) / 2;
        const textY = canvas.height / 2 + Math.sin(startAngle + sliceAngle / 2) * (canvas.height / 2) / 2;
        ctx.fillStyle = "#000";
        ctx.font = "bold 14px Arial";
        ctx.fillText(segment.label, textX, textY);

        startAngle += sliceAngle;
});

    </script>
</body>
</html>