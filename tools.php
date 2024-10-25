<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools</title>
    <link rel="stylesheet" href="CSS/tools.css" type="text/css">
    <link rel="stylesheet" href="assets/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <h2>Pomodoro Timer <i class="fas fa-stopwatch"></i></h2>
    <div class="pomodoro">
        <div class="container">
            <div class="section_container">
                <button id="focus" class="btn btn-timer btn-focus">Focus</button>
                <button id="shortbreak" class="btn btn-shortbreak">Short Break</button>
            <button id="longbreak" class="btn btn-longbreak">Long Break</button>
            </div>
            <div class="time-btn-container">
                <span id="time"></span>
                <div class="btn-container">
                    <button id="btn-start" class="show">Start</button>
                    <button id="btn-pause" class="hide">Pause</button>
                    <button id="btn-reset" class="hide">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="guide">
            <div class="def">
                <h3>Historique</h3>
                <p>Inventé par Francesco Cirillo dans les années 1980, le Pomodoro Timer aide à gérer le temps de travail en cycles de 25 minutes.</p>
            </div>
            <br>
            <div class="guid">
                <h3>Guide d'utilisation</h3>
                <p>1. Choisissez une tâche à accomplir.</p>
                <p>2. Réglez le timer sur 25 minutes.</p>
                <p>3. Travaillez sans interruption jusqu'à ce que le timer s'arrête.</p>
                <p>4. Prendre une courte pause de 5 minutes.</p>
                <p>5. Répétez le processus 4 fois, puis prenez une pause plus longue de 15-30 minutes.</p>
            </div>
            <br>
            <div class="avt">
                <h3>Avantages</h3>
                <p>Améliore la concentration , réduit la procrastination , facilite la gestion du temps.</p>
            </div>
        </div>
    </div>
    <div class="todo">
        <h2 id="tit">To-do List <i class="fas fa-check-square"></i></h2>
        <div class="container1">
            <div class="guide">
                <div class="def">
                    <h3>Historique</h3>
                    <p>L'idée de la to-do list, ou liste de choses à faire, remonte à des pratiques ancestrales d'organisation et de gestion de tâches.</p>
                </div>
                <br>
                <div class="guid">
                    <h3>Guide d'utilisation</h3>
                    <p>1. Ajouter une tâche : en cliquant sur "Ajouter du texte".</p>
                    <p>2. Tapez votre tâche puis cliquez sur le bouton "Ajouter" pour enregistrer la tâche.</p>
                    <p>3. Marquer une tâche comme terminée : cliquez sur le cercle à gauche de la tâche.</p>
                    <p>4. Supprimer une tâche : Cliquez sur "X" à droite de la tâche que vous souhaitez supprimer.</p>
                </div>
                <br>
                <div class="avt">
                    <h3>Avantages</h3>
                    <p>Productivité accrue , Suivi des progrès , réduction du stress.</p>
                </div>
            </div>
            <div class="todo_app">
                <h2>To-do List <img src="../img/to-do-list.png" alt=""></h2>
                <div class="row">
                    <input type="text" id="input_box" placeholder="Ajouter du texte">
                    <button onclick="addTask()">Ajouter</button>
                </div>
                <ul id="list_container">
                    <!-- <li class="checked">Task 1</li>
                    <li>Task 2</li>
                    <li>Task 3</li> -->
                </ul>
            </div>
        </div>
    </div>
    <script src="../JS/app.js"></script>
</body>
</html>