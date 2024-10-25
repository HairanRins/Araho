<?php
session_start();
include 'edit_profil.php';

$mysqli = new mysqli("localhost", "username", "password", "task_management");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// $result = $mysqli->query("SELECT COUNT(*) AS total, 
//                                  SUM(status = 'Ouvert') AS Ouvert, 
//                                  SUM(status = 'Complet') AS Complet, 
//                                  SUM(status = 'Annule') AS Annule 
//                           FROM manage");
// $counts = $result->fetch_assoc();

// $result = $mysqli->query("SELECT * FROM manage");
// $tasks = $result->fetch_all(MYSQLI_ASSOC);

// $_SESSION['user_id'] = $userId;
// $query = "SELECT 
//     SUM(status = 'Annule') AS cancelled_count,
//     SUM(status = 'Complet') AS completed_count,
//     SUM(status = 'Ouvert') AS open_count
// FROM manage 
// WHERE user_id = ?";

// $stmt1 = $mysqli->prepare($query);
// $stmt1->bind_param("i", $userId);
// $stmt1->execute();
// $result1 = $stmt1->get_result();

// $counts = $result1->fetch_assoc();


// $stmt = $mysqli->prepare("SELECT COUNT(*) AS total, 
//                                  SUM(status = 'Ouvert') AS Ouvert, 
//                                  SUM(status = 'Complet') AS Complet, 
//                                  SUM(status = 'Annule') AS Annule 
//                           FROM manage
//                           WHERE user_id = ?");
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result1 = $stmt->get_result();
// $counts = $result1->fetch_assoc();
// $stmt = $mysqli->prepare("SELECT * FROM manage WHERE user_id = ?");
// $stmt->bind_param("i", $userId);
// $stmt->execute();
// $result = $stmt->get_result();
// $tasks = $result1->fetch_all(MYSQLI_ASSOC);

$userId = isset($_GET['id']) ? $_GET['id'] : null;
$_SESSION['user_id'] = $userId;
$userId = intval($_GET['id']);

// Query to get the counts of each task status
$query = "SELECT 
    (SELECT COUNT(*) FROM manage WHERE user_id = $userId) as total,
    (SELECT COUNT(*) FROM manage WHERE user_id = $userId AND status = 'Ouvert') as open,
    (SELECT COUNT(*) FROM manage WHERE user_id = $userId AND status = 'Complet') as completed,
    (SELECT COUNT(*) FROM manage WHERE user_id = $userId AND status = 'Annule') as canceled";

$result = $mysqli->query($query);

if ($result) {
    $counts = $result->fetch_assoc();
} else {
    echo "Error: " . $mysqli->error;
}



$result = $mysqli->query("SELECT * FROM manage WHERE user_id = $userId");

$tasks = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

if (!$userId) {
    header('Location: dashboard.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'access');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$stmt = $conn->prepare('SELECT name, email, password, profile_image FROM users WHERE id = ?');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $password, $profileImage);
$stmt->fetch();

$stmt->close();
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="assets/fontawesome-free-6.2.1-web/css/all.css">
    <link rel="stylesheet" href="CSS/dash.css">
    <link rel="stylesheet" href="CSS/table.css">
    <link rel="stylesheet" href="CSS/tooly.css">
    <link rel="stylesheet" href="CSS/edit.css">
    <script src="JS/scripts.js" defer></script>
</head>
<body>
    <input type="hidden" id="user_id" value="<?= $userId ?>">
    <div id="sidebar">
        <a href="#" class="brand">
            <img src="img/1715279265111.jpg" alt="logo">
            <span class="text">Araho</span>
        </a>
        <ul class="sidemenu top">
            <li data-section="accueil" class="active nav_access">
                <a href="#">
                    <i class="fas fa-home"></i>
                    <span class="text">Accueil</span>
                </a>
            </li>
            <li class="nav_access" data-section="mes-taches">
                <a href="#">
                    <i class="fas fa-check-circle"></i>
                    <span class="text">Mes tâches</span>
                </a>
            </li>
            <li class="nav_access" data-section="profil">
                <a href="#">
                    <i class="fas fa-user"></i>
                    <span class="text">Profil</span>
                </a>
            </li>
            <li class="nav_access" data-section="objectifs">
                <a href="#">
                    <i class="fas fa-crosshairs"></i>
                    <span class="text">Objectifs</span>
                </a>
            </li>
            <li class="nav_access" data-section="outils">
                <a href="#">
                    <i class="fas fa-calendar"></i>
                    <span class="text">Outils</span>
                </a>
            </li>
        </ul>
        <ul class="sidemenu">
            <li>
                
            </li>
            <li>
                <a href="logout.php" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="text">Déconnexion</span>
                </a>
            </li>
        </ul>
    </div>
    <div id="content">
        <nav>
            <i class="fas fa-bars"></i>
            <a href="#" class="nav_link">Categories</a>
            <form action="#" id="searchForm">
                <div class="form_input">
                    <input type="search"  id="searchInput" list="goalSuggestions" placeholder="Recherche...">
                    <datalist id="goalSuggestions"></datalist>
                    <button type="submit" class="search_btn"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <a href="#" class="notification">
                <i class="fas fa-bell"></i>
                <span class="num"></span>
            </a>
            <a href="#" class="profil">
                <?php if ($profileImage): ?>
                    <img src="img/<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Image" width="100px">
                <?php endif; ?>
            </a>
        </nav>
        <div class="access" id="access">
        <section id="accueil">
        <h2>Bienvenue, <span><?php echo $name; ?></span></h2>
        <div class="datcont">
        <div id="datetime"></div>
        </div>
        <div class="contcat">
            <div class="contstat">
                <div class="stats">
                    <div class="stat-item">
                        <span style="color: teal;">●</span>
                        <span>Total des Tâches</span>
                        <span id="totalTasks"><?= $counts['total'] ?></span></p>
                    </div>
                    <div class="stat-item">
                        <span style="color: #f39c12;">●</span>
                        <span>Tâches Ouvertes</span>
                        <span id="openTasks"><?= $counts['open'] ?></span></p>
                    </div>
                    <div class="stat-item">
                        <span style="color: #2ecc71;">●</span>
                        <span>Tâches Complétées</span>
                        <span><span id="completedTasks"><?= $counts['completed'] ?></span>
                    </div>
                    <div class="stat-item">
                        <span style="color: #e74c3c;">●</span>
                        <span>Tâches Annulées</span>
                        <span id="canceledTasks"><?= $counts['canceled'] ?></span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="tasksChart"></canvas>
                    <div class="chart-label" id="totalTasksLabel"><?= $counts['total'] ?><br><span style="font-size: 16px;">Total Tâches</span></div>
                </div>
            </div>
            <div class="calendar">
                <div class="month">
                    <button id="prevMonth">&lt;</button>
                    <div>
                        <div class="month-name" id="monthName"></div>
                        <div class="month-year" id="year"></div>
                    </div>
                    <button id="nextMonth">&gt;</button>
                </div>
                <div class="days-of-week">
                    <div>Dim</div>
                    <div>Lun</div>
                    <div>Mar</div>
                    <div>Mer</div>
                    <div>Jeu</div>
                    <div>Ven</div>
                    <div>Sam</div>
                </div>
                <div class="days" id="days"></div>
            </div>
        </div>
        </div>
        </section>
        <section id="mes-taches" style="display:none;">
            <!-- <div class="summary">
        <div>
            <h3>Cancelled Tasks</h3>
            <p></p>
        </div>
        <div>
            <h3>Completed Tasks</h3>
            <p></p>
        </div>
        <div>
            <h3>Open Tasks</h3>
            <p></p>
        </div>
    </div> -->
    
    <div class="task-countss">
        <div class="task-count total-tasks">
            <i class="fas fa-tasks"></i>
            <p>Total des Tâches: <?= $counts['total'] ?></p>
        </div>
        <div class="task-count open-tasks">
            <i class="fas fa-folder-open"></i>
            <p>Tâches Ouvertes: <?= $counts['open'] ?></p>
        </div>
        <div class="task-count completed-tasks">
            <i class="fas fa-check-circle"></i>
            <p>Tâches Complétées: <?= $counts['completed'] ?></p>
        </div>
        <div class="task-count canceled-tasks">
            <i class="fas fa-times-circle"></i>
            <p>Tâches Annulées: <?= $counts['canceled'] ?></p>
        </div>
    </div>
<button id="addTaskBtn" class="btn">Ajouter une tâche</button>

<div id="addTaskFormContainer" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="addTaskForm" method="POST" action="add_task.php">
            <input type="hidden" name="user_id" value="<?= $userId; ?>">
            
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Ouvert">Ouvert</option>
                    <option value="Complet">Complet</option>
                    <option value="Annule">Annule</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="priority">Priorité:</label>
                <select name="priority" id="priority">
                    <option value="Faible">Faible</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Important">Important</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" name="name" id="name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required style="resize: none;"></textarea>
            </div>
            
            <div class="form-group">
                <label for="due_date">Échéance:</label>
                <input type="date" name="due_date" id="due_date" required>
            </div>
            
            <button type="submit" class="submit-button">Ajouter la tâche</button>
        </form>
    </div>
</div>

    <table>
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Status</th>
                <th>Priorité</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Échéance</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= $task['id'] ?></td>
                    <td><?= $task['status'] ?></td>
                    <td><?= $task['priority'] ?></td>
                    <td><?= $task['name'] ?></td>
                    <td><?= $task['description'] ?></td>
                    <td><?= $task['due_date'] ?></td>
                    <td>
                        <button class="editBtn" data-id="<?= $task['id'] ?>" style="color: #3498db; margin-left:10px; margin-right:8px;"><i class="fas fa-pen"></i></button>
                        <input type="hidden" id="user_id" name="user_id" value="<?= $userId ?>">
                        <a href="delete_task.php?id=<?= $task['id'] ?>&user_id=<?= $userId ?>" onclick="return confirm('Êtes-vous certain de supprimer la tâche?');" style="color: #e74c3c;">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="editTaskFormContainer" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="editTaskForm" method="POST" action="edit_task.php">
            <input type="hidden" name="id" id="editTaskId">
            <input type="hidden" id="user_id" name="user_id" value="<?= $userId ?>">
            
            <div class="form-group">
                <label for="editStatus">Status:</label>
                <select name="status" id="editStatus">
                    <option value="Ouvert">Ouvert</option>
                    <option value="Complet">Complet</option>
                    <option value="Annule">Annule</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="editPriority">Priorité:</label>
                <select name="priority" id="editPriority">
                    <option value="Faible">Faible</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Important">Important</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="editName">Nom:</label>
                <input type="text" name="name" id="editName" required>
            </div>
            
            <div class="form-group">
                <label for="editDescription">Description:</label>
                <textarea name="description" id="editDescription" required style="resize:none;"></textarea>
            </div>
            
            <div class="form-group">
                <label for="editDueDate">Échéance:</label>
                <input type="date" name="due_date" id="editDueDate" required>
            </div>
            
            <button type="submit" class="submit-button">Mettre à jour</button>
        </form>
    </div>
</div>

        </section>
        <section id="profil" style="display:none;">
        <div class="container">
        <h1>Modifier le Profil</h1>
        <form action="edit_profil.php" method="POST" enctype="multipart/form-data">
            <div class="form-group" id="img_form">
                <div class="profile-image-container">
                    <img src="img/<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Image" class="profile-image">
                    <input type="file" id="profile_image" name="profile_image" class="profile-image-input">
                    <label for="profile_image" class="profile-image-icon">
                        <i class="fas fa-pen"></i>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Nouveau Mot de passe (laisser vide pour ne pas changer):</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <button type="submit">Enregistrer les modifications</button>
            </div>
        </form>
        </section>
        <section id="objectifs" style="display:none;">
            <div class="obj">
            <div class="objectifs">
            <button id="addGoalBtn">Ajouter d'objectif</button>
            <div id="goalFormContainer" class="modal">
                <form id="goalForm" class="modal-content">
                <div class="form-group">
            <label for="goalName" style="color:#3c91e6">Nom de l'objectif:</label>
            <input type="text" id="goalName" name="goalName" required>
        </div>
        
        <div class="form-group">
            <label for="goalType"  style="color:#3c91e6">Type d'objectif:</label>
            <select id="goalType" name="goalType" required>
                <option value="personal">Personnel</option>
                <option value="professional">Professionnelle</option>
            </select>
        </div>
        <div id="tasksContainer" class="form-group">
            <label for="task1">Tâche 1:</label>
            <input type="text" id="task1" name="tasks[]">
            
            <label for="task2">Tâche 2:</label>
            <input type="text" id="task2" name="tasks[]">
            
            <label for="task3">Tâche 3:</label>
            <input type="text" id="task3" name="tasks[]">
            
            <label for="task4">Tâche 4:</label>
            <input type="text" id="task4" name="tasks[]">
            
            <label for="task5">Tâche 5:</label>
            <input type="text" id="task5" name="tasks[]">
        </div>
        
                    <button type="submit" class="submit-btn">Valider</button>
                </form>
            </div>
            <div id="goalsContainer"></div>
                <button id="completedGoalsBtn">Les objectifs atteints</button>
                <button id="resetBtn" style="display:none;">Réinitialiser</button>
                <div id="completedGoalsFormContainer" class="modal">
                    <div class="modal-content">
                        <h2>Objectifs atteints</h2>
                    <div id="completedGoalsList"></div>
                 </div>
            </div>
            
            </div>
            <div class="illuso">
                <img src="img/1719895482473.jpg" alt="">
            </div>
            </div>
            <!-- <div class="loader">
                <span></span>
            </div> -->
        </section>
        <section id="outils" style="display:none;">
        <nav class="navbar">
        <ul>
            <li><a href="#kanban" class="nav-link active">kanban</a></li>
            <li><a href="#pomodoro" class="nav-link">Pomodoro</a></li>
            <li><a href="#agendaa" class="nav-link">Agenda</a></li>
            <li><a href="#notes" class="nav-link">Notes</a></li>
        </ul>
    </nav>
    <div id="kanban" class="section active">
    <div class="kanban">
    <h1>Tableau Kanban</h1>
        <button id="ajouterObjectifBtn">Ajouter Objectif</button>
        
        <div class="kanban-columns">
            <div id="todo" class="kanban-column">
                <h2>À faire</h2>
                <div id="todoItems" class="kanban-items"></div>
            </div>
            <div id="in-progress" class="kanban-column">
                <h2>En cours</h2>
                <div id="inProgressItems" class="kanban-items"></div>
            </div>
            <div id="done" class="kanban-column">
                <h2>Fait</h2>
                <div id="doneItems" class="kanban-items"></div>
            </div>
        </div>

        <div id="objectifFormContainer" class="form-container">
            <div class="form">
                <h2 id="titreFormulaire">Ajouter Objectif</h2>
                <label for="nomObjectif">Nom de l'objectif</label>
                <input type="text" id="nomObjectif">
                <label for="tacheObjectif">Tâche</label>
                <input type="text" id="tacheObjectif">
                <label for="importanceObjectif">Importance</label>
                <select id="importanceObjectif">
                    <option value="important">Important</option>
                    <option value="urgent">Urgent</option>
                    <option value="utile">Utile</option>
                </select>
                <div class="form-buttons">
                    <button id="sauvegarderObjectifBtn">Sauvegarder</button>
                    <button id="fermerFormulaireObjectifBtn">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="completed-section">
        <h2>Objectifs Complétés</h2>
        <div id="objectifsCompletésContainer"></div>
        <p>Total complété: <span id="completedCount">0</span></p>
    </div>

    </div>

    <div id="pomodoro" class="section">
        <div class="pomodoro">
        <div class="container1">
            <div class="section_container">
                <button id="focus" class="btn btn-timer btn-focus">Focus</button>
                <button id="shortbreak" class="btn btn-shortbreak">Short Break</button>
            <button id="longbreak" class="btn btn-longbreak">Long Break</button>
            </div>
            <div class="time-btn-container">
                <span id="time"></span>
                <div class="btn-container">
                    <button id="btn-start" class="show">Start</button>
                    <button id="btn-pause" class="hides">Pause</button>
                    <button id="btn-reset" class="hides">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="guid">
                <h3>Guide d'utilisation</h3>
                <p>1. Choisissez une tâche à accomplir.</p>
                <p>2. Réglez le timer sur 25 minutes.</p>
                <p>3. Travaillez sans interruption jusqu'à ce que le timer s'arrête.</p>
                <p>4. Prendre une courte pause de 5 minutes.</p>
                <p>5. Répétez le processus 4 fois, puis prenez une pause plus longue de 15-30 minutes.</p>
        </div>
        </div>
    </div>
    <div id="agendaa" class="section">
        <div id="agenda">
        <button id="ajoutTaskBtn">Ajouter un événement</button>
        
        <div id="taskFormContainer" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="taskForm" method="POST" action="add_event.php">
            <h2>Ajouter un événement</h2>
            
            <div class="form-group">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea id="description" name="description" style="resize: none;"></textarea>
            </div>
            
            <div class="form-group">
                <label for="importance">Ordre d'importance :</label>
                <select id="importance" name="importance">
                    <option value="important">Important</option>
                    <option value="necessary">Nécessaire</option>
                    <option value="medium">Moyen</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="day">Jour :</label>
                <input type="date" id="day" name="day" required>
            </div>
            
            <div class="form-group">
                <label for="startTime">Heure de début :</label>
                <input type="time" id="startTime" name="startTime" required>
            </div>
            
            <div class="form-group">
                <label for="endTime">Heure de fin :</label>
                <input type="time" id="endTime" name="endTime" required>
            </div>

            <button type="submit" class="submit-button">Sauvegarder</button>
        </form>
    </div>
</div>
        <table id="tasksTable">
            <thead>
                <tr>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                    <th>Dimanche</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="lundi" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                    <td id="mardi" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                    <td id="mercredi" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                    <td id="jeudi" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                    <td id="vendredi" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                    <td id="samedi" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                    <td id="dimanche" class="day-section" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div id="notes" class="section">
        <div class="container">
            <p>"Ajoutez vos notes ici pour mieux organiser vos pensées ! Cliquez sur le <span>'+'</span> et choisissez la catégorie appropriée pour une gestion optimale de vos tâches."</p>
        <div class="note-category" id="principal">
            <h2>Principal</h2>
            <button class="add-note" onclick="openForm('Principal')">+</button>
            <div class="notes"></div>
        </div>
        <div class="note-category" id="idea">
            <h2>Idée</h2>
            <button class="add-note" onclick="openForm('Idea')">+</button>
            <div class="notes"></div>
        </div>
        <div class="note-category" id="croissance">
            <h2>Croissance</h2>
            <button class="add-note" onclick="openForm('Croissance')">+</button>
            <div class="notes"></div>
        </div>
        </div>
    </div>

    <div class="note-form" id="noteForm">
        <form id="formNote" method="POST" action="save_note.php">
            <h2>Ajouter une note</h2>
            <label for="category">Catégorie :</label>
            <select id="category" name="category">
                <option value="Principal">Principal</option>
                <option value="Idea">Idée</option>
                <option value="Croissance">Croissance</option>
            </select><br>
            <label for="color">Couleur :</label>
            <select id="color" name="color">
                <option value="jaune">Jaune</option>
                <option value="vert">Vert</option>
                <option value="rouge">Rouge</option>
                <option value="bleu">Bleu</option>
                <option value="violet">Violet</option>
            </select><br>
            <label for="content1">Contenu :</label><br>
            <textarea id="content1" name="content" rows="4" required style="resize:none;"></textarea><br>
            <button type="submit">Ajouter</button>
            <button type="button" onclick="closeForm()">Annuler</button>
        </form>
    </div>
        </section>
    </div>
    </div>
    
<script src="JS/dash.js"></script>
<script src="JS/suit.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel"></script>
<script>
    const userId = <?php echo $userId; ?>
</script>
<script>
   // Assume these values are dynamically assigned from your PHP code
const taskData = {
    total: <?= $counts['total'] ?>,
    open: <?= $counts['open'] ?>,
    completed: <?= $counts['completed'] ?>,
    canceled: <?= $counts['canceled'] ?>
};

document.getElementById('totalTasks').textContent = taskData.total;
document.getElementById('openTasks').textContent = taskData.open;
document.getElementById('completedTasks').textContent = taskData.completed;
document.getElementById('canceledTasks').textContent = taskData.canceled;
document.getElementById('totalTasksLabel').innerHTML = `${taskData.total}<br><span style="font-size: 16px;">Total Tâches</span>`;

const ctx = document.getElementById('tasksChart').getContext('2d');
const tasksChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Ouvert', 'Complet', 'Annule'],
        datasets: [{
            label: 'Statistiques des Tâches',
            data: [taskData.open, taskData.completed, taskData.canceled],
            backgroundColor: ['#f39c12', '#2ecc71', '#e74c3c'],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            },
        },
        cutout: '70%',
    }
});

</script>
</body>
</html>

<?php
$mysqli->close();
?>