document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('.section');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all nav links
            navLinks.forEach(nav => nav.classList.remove('active'));

            // Add active class to clicked nav link
            this.classList.add('active');

            // Hide all sections
            sections.forEach(section => section.classList.remove('active'));

            // Show clicked section
            const target = document.querySelector(this.getAttribute('href'));
            target.classList.add('active');
        });
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('ajouterObjectifBtn').addEventListener('click', function() {
        ouvrirFormulaire();
    });

    document.getElementById('fermerFormulaireObjectifBtn').addEventListener('click', function() {
        fermerFormulaire();
    });

    document.getElementById('sauvegarderObjectifBtn').addEventListener('click', function() {
        sauvegarderObjectif();
    });

    afficherObjectifs();
    afficherObjectifsCompletés();
});

let currentEditId = null;

function ouvrirFormulaire(objectif = null) {
    document.getElementById('objectifFormContainer').style.display = 'flex';
    if (objectif) {
        document.getElementById('nomObjectif').value = objectif.nom;
        document.getElementById('tacheObjectif').value = objectif.tache;
        document.getElementById('importanceObjectif').value = objectif.importance;
        document.getElementById('titreFormulaire').innerText = 'Modifier Objectif';
        currentEditId = objectif.id;
    } else {
        document.getElementById('nomObjectif').value = '';
        document.getElementById('tacheObjectif').value = '';
        document.getElementById('importanceObjectif').value = 'important';
        document.getElementById('titreFormulaire').innerText = 'Ajouter Objectif';
        currentEditId = null;
    }
}

function fermerFormulaire() {
    document.getElementById('objectifFormContainer').style.display = 'none';
}

function sauvegarderObjectif() {
    const nom = document.getElementById('nomObjectif').value;
    const tache = document.getElementById('tacheObjectif').value;
    const importance = document.getElementById('importanceObjectif').value;

    if (!nom || !tache || !importance) {
        alert('Tous les champs sont obligatoires');
        return;
    }

    if (currentEditId !== null) {
        modifierObjectif(currentEditId, nom, tache, importance);
    } else {
        ajouterObjectif(nom, tache, importance);
    }
    fermerFormulaire();
}

function ajouterObjectif(nom, tache, importance) {
    const objectifs = obtenirObjectifs();
    if (objectifs.length >= 10) {
        alert('Maximum de 10 objectifs atteint');
        return;
    }

    const id = Date.now();
    objectifs.push({ id, nom, tache, importance, statut: 'todo' });
    localStorage.setItem(`objectifs_${userId}`, JSON.stringify(objectifs));
    afficherObjectifs();
}

function modifierObjectif(id, nom, tache, importance) {
    const objectifs = obtenirObjectifs();
    const objectifIndex = objectifs.findIndex(objectif => objectif.id === id);
    objectifs[objectifIndex] = { id, nom, tache, importance, statut: objectifs[objectifIndex].statut };
    localStorage.setItem(`objectifs_${userId}`, JSON.stringify(objectifs));
    afficherObjectifs();
}

function supprimerObjectif(id) {
    let objectifs = obtenirObjectifs();
    const objectifIndex = objectifs.findIndex(objectif => objectif.id === id);
    if (objectifs[objectifIndex].statut === 'done') {
        const objectifCompleté = objectifs.splice(objectifIndex, 1)[0];
        ajouterObjectifCompleté(objectifCompleté);
    } else {
        objectifs = objectifs.filter(objectif => objectif.id !== id);
    }
    localStorage.setItem(`objectifs_${userId}`, JSON.stringify(objectifs));
    afficherObjectifs();
}

function ajouterObjectifCompleté(objectif) {
    const objectifsCompletés = obtenirObjectifsCompletés();
    objectifsCompletés.push(objectif);
    localStorage.setItem(`objectifsCompletés_${userId}`, JSON.stringify(objectifsCompletés));
    afficherObjectifsCompletés();
}

function supprimerObjectifCompleté(id) {
    let objectifsCompletés = obtenirObjectifsCompletés();
    objectifsCompletés = objectifsCompletés.filter(objectif => objectif.id !== id);
    localStorage.setItem(`objectifsCompletés_${userId}`, JSON.stringify(objectifsCompletés));
    afficherObjectifsCompletés();
}

function compléterObjectif(id) {
    const objectifs = obtenirObjectifs();
    const objectifIndex = objectifs.findIndex(objectif => objectif.id === id);
    objectifs[objectifIndex].statut = 'done';
    localStorage.setItem(`objectifs_${userId}`, JSON.stringify(objectifs));
    afficherObjectifs();
}

function obtenirObjectifs() {
    return JSON.parse(localStorage.getItem(`objectifs_${userId}`)) || [];
}

function obtenirObjectifsCompletés() {
    return JSON.parse(localStorage.getItem(`objectifsCompletés_${userId}`)) || [];
}

function afficherObjectifs() {
    const todoItems = document.getElementById('todoItems');
    const inProgressItems = document.getElementById('inProgressItems');
    const doneItems = document.getElementById('doneItems');
    
    todoItems.innerHTML = '';
    inProgressItems.innerHTML = '';
    doneItems.innerHTML = '';

    obtenirObjectifs().forEach(objectif => {
        const objectifDiv = document.createElement('div');
        objectifDiv.className = 'kanban-item';
        objectifDiv.id = objectif.id;
        objectifDiv.draggable = true;
        objectifDiv.ondragstart = dragStart;

        const objectifInfo = document.createElement('div');
        objectifInfo.innerHTML = `<strong>${objectif.nom}</strong><br>${objectif.tache}<br><em class="${objectif.importance}">${objectif.importance}</em>`;

        const buttonsDiv = document.createElement('div');
        buttonsDiv.classList.add('buttons-container');

        const editBtn = document.createElement('button');
        editBtn.innerHTML = '✏️';
        editBtn.onclick = () => ouvrirFormulaire(objectif);

        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '🗑️';
        deleteBtn.onclick = () => supprimerObjectif(objectif.id);

        const completeBtn = document.createElement('button');
        completeBtn.innerHTML = '✔️';
        completeBtn.onclick = () => compléterObjectif(objectif.id);

        buttonsDiv.appendChild(editBtn);
        buttonsDiv.appendChild(deleteBtn);
        if (objectif.statut !== 'done') buttonsDiv.appendChild(completeBtn);

        objectifDiv.appendChild(objectifInfo);
        objectifDiv.appendChild(buttonsDiv);

        if (objectif.statut === 'todo') {
            todoItems.appendChild(objectifDiv);
        } else if (objectif.statut === 'in-progress') {
            inProgressItems.appendChild(objectifDiv);
        } else if (objectif.statut === 'done') {
            doneItems.appendChild(objectifDiv);
        }
    });
}

function afficherObjectifsCompletés() {
    const objectifsCompletésContainer = document.getElementById('objectifsCompletésContainer');
    objectifsCompletésContainer.innerHTML = '';

    obtenirObjectifsCompletés().forEach(objectif => {
        const objectifDiv = document.createElement('div');
        objectifDiv.className = 'completed-item';
        objectifDiv.id = objectif.id;

        const objectifInfo = document.createElement('div');
        objectifInfo.innerHTML = `<strong>${objectif.nom}</strong><br>${objectif.tache}<br><em class="${objectif.importance}">${objectif.importance}</em>`;

        const deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = '🗑️';
        deleteBtn.onclick = () => supprimerObjectifCompleté(objectif.id);

        objectifDiv.appendChild(objectifInfo);
        objectifDiv.appendChild(deleteBtn);

        objectifsCompletésContainer.appendChild(objectifDiv);
    });

    document.getElementById('completedCount').innerText = obtenirObjectifsCompletés().length;
}

function dragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.id);
}

function dragOver(event) {
    event.preventDefault();
}

function drop(event, statut) {
    event.preventDefault();
    const id = event.dataTransfer.getData('text');
    const objectifs = obtenirObjectifs();
    const objectifIndex = objectifs.findIndex(objectif => objectif.id === parseInt(id));
    objectifs[objectifIndex].statut = statut;
    localStorage.setItem(`objectifs_${userId}`, JSON.stringify(objectifs));
    afficherObjectifs();
}

document.querySelectorAll('.kanban-column').forEach(column => {
    column.ondragover = dragOver;
    column.ondrop = (event) => drop(event, column.id.replace('Items', ''));
});


document.addEventListener('DOMContentLoaded', loadNotes);

function openForm(category) {
    document.getElementById("category").value = category;
    document.getElementById("noteForm").style.display = "block";
}

function closeForm() {
    document.getElementById("noteForm").style.display = "none";
}

function loadNotes() {
    fetch('get_notes.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(note => {
                const noteElement = document.createElement('div');
                noteElement.classList.add('note', note.color);
                noteElement.innerHTML = `
                    ${note.content}
                    <button onclick="deleteNote(${note.id})">X</button>
                `;
                document.getElementById(note.category.toLowerCase()).querySelector('.notes').appendChild(noteElement);
            });
        });
}

function deleteNote(id) {
    fetch(`delete_note.php?id=${id}`, { method: 'DELETE' })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                location.reload();
            }
        });
}





document.addEventListener('DOMContentLoaded', () => {
    const ajoutTaskBtn = document.getElementById('ajoutTaskBtn');
    const taskFormContainer = document.getElementById('taskFormContainer');
    const taskForm = document.getElementById('taskForm');
    const closeModal = document.querySelectorAll('.close');
    const tasksTable = document.getElementById('tasksTable');
    const userId = getUserIdFromUrl();

    let tasks = loadFromLocalStorage(`tasks_${userId}`) || [];

    ajoutTaskBtn.addEventListener('click', () => {
        openForm();
    });

    closeModal.forEach(btn => btn.addEventListener('click', () => {
        closeForm();
    }));

    taskForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(taskForm);
        const task = Object.fromEntries(formData.entries());
        
        tasks.push(task);
        
        saveToLocalStorage(`tasks_${userId}`, tasks);
        updateTasksTable();
        closeForm();
    });

    function openForm() {
        taskForm.reset();
        taskFormContainer.style.display = 'block';
    }

    function closeForm() {
        taskFormContainer.style.display = 'none';
    }

    function updateTasksTable() {
        const days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
        days.forEach(day => {
            const daySection = document.getElementById(day);
            daySection.innerHTML = '';
            const dayTasks = tasks.filter(task => new Date(task.day).getDay() === days.indexOf(day) + 1);

            dayTasks.forEach((task, index) => {
                const taskDiv = document.createElement('div');
                taskDiv.classList.add('task', task.importance);
                taskDiv.innerHTML = `
                    <h4>${task.title}</h4>
                    <p>${task.description}</p>
                    <p><strong>Date:</strong> ${task.day}</p>
                    <p><strong>Heure:</strong> ${task.startTime} - ${task.endTime}</p>
                    <button onclick="deleteTask(${index})" style="border:1px solid red; border-radius:4px; background:none; cursor:pointer; padding:5px; margin-top:7px; color:red;">Supprimer</button>
                `;
                daySection.appendChild(taskDiv);
            });
        });
    }

    function loadFromLocalStorage(key) {
        return JSON.parse(localStorage.getItem(key));
    }

    function saveToLocalStorage(key, data) {
        localStorage.setItem(key, JSON.stringify(data));
    }

    window.deleteTask = (index) => {
        tasks.splice(index, 1);
        saveToLocalStorage(`tasks_${userId}`, tasks);
        updateTasksTable();
    }

    function getUserIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('id');
    }

    // Initial call to display tasks from localStorage
    updateTasksTable();
});





let focusButton = document.getElementById('focus')
let buttons = document.querySelectorAll('.btn')
let shortBreakButton = document.getElementById('shortbreak')
let longBreakButton = document.getElementById('longbreak')
let startBtn = document.getElementById('btn-start')
let pauseBtn = document.getElementById('btn-pause')
let resetBtn = document.getElementById('btn-reset')
let time = document.getElementById('time')
let set;
let active = 'focus'
let count = 59
let paused = true
let minCount = 24
time.textContent = `${minCount + 1}:00`
const appendZero = (value) => {
    value = value < 10 ? `0${value}` : value
    return value
}

resetBtn.addEventListener('click', (
    resetTime = () => {
        pauseTimer()
        switch(active) {
            case 'long':
                minCount = 14
                break
            case 'short':
                minCount = 4
                break   
            default:
                minCount = 24
                break
        }
        count = 59
        time.textContent = `${minCount + 1}:00`
    })
)

const removeFocus = () => {
    buttons.forEach((btn) => {
        btn.classList.remove('btn-focus')
    })
}

focusButton.addEventListener('click', () => {
    removeFocus()
    focusButton.classList.add('btn-focus') 
    pauseTimer()
    minCount = 24
    count = 59
    time.textContent = `${minCount + 1}:00`
})

shortBreakButton.addEventListener('click', () => {
    active = 'short'
    removeFocus()
    shortBreakButton.classList.add('btn-focus')
    pauseTimer()
    minCount = 4
    count = 59
    time.textContent = `${appendZero(minCount+1)}:00`
})

longBreakButton.addEventListener('click', () => {
    active = 'long'
    removeFocus()
    longBreakButton.classList.add('btn-focus')
    pauseTimer()
    minCount = 14
    count = 59
    time.textContent = `${minCount+1}:00`
})

pauseBtn.addEventListener('click', (pauseTimer = () => {
   paused = true
    clearInterval(set)
    startBtn.classList.remove('hides')
    pauseBtn.classList.remove('show')
    resetBtn.classList.remove('show')
  })
)

startBtn.addEventListener('click', () => {
    resetBtn.classList.add('show')
    pauseBtn.classList.add('show')
    startBtn.classList.add('hides')
    startBtn.classList.remove('show')
    if (paused) {
        paused = false
        time.textContent = `${appendZero(minCount)}:${appendZero(count)}`
        set = setInterval(() => {
            count--
            time.textContent = `${appendZero(minCount)}:${appendZero(count)}`
            if (count == 0) {
                if (minCount != 0) {
                    minCount--
                    count = 60
                } else {
                    clearInterval(set)
                }
            }
        }, 1000)
    }
})



