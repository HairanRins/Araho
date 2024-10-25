const allSideMenu = document.querySelectorAll('#sidebar .sidemenu.top li a')
allSideMenu.forEach(item=> {
    const li = item.parentElement
    item.addEventListener('click', function () {
        allSideMenu.forEach(i=> {
            i.parentElement.classList.remove('active')
        })
        li.classList.add('active')
    })
})

const menuBar = document.querySelector('#content nav .fas.fa-bars')
const sideBar = document.getElementById('sidebar')
menuBar.addEventListener('click', function () {
    sideBar.classList.toggle('hide')
})
const searchButton = document.querySelector('#content nav form .form_input button')
const searchButtonIcon = document.querySelector('#content nav form .form_input button .fas')
const searchForm = document.querySelector('#content nav form')
searchButton.addEventListener('click', function(e) {
    if (window.innerWidth < 576) {
        e.preventDefault()
        searchForm.classList.toggle('show')
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('fa-search', 'fa-times')
        } else {
            searchButtonIcon.classList.replace('fa-times', 'fa-search')
        }
    }
})
if (window.innerWidth < 768) {
    sideBar.classList.add('hide')
} else if(window.innerWidth < 576) {
    searchButtonIcon.classList.replace('fa-times', 'fa-search')
    searchForm.classList.remove('show')
}
window.addEventListener('resize', function() {
    if(this.innerWidth > 576) {
        searchButtonIcon.classList.replace('fa-times', 'fa-search')
        searchForm.classList.remove('show')
    }
    if (this.innerWidth >= 976) {
        sideBar.classList.remove('hide');
    } else if (this.innerWidth < 768) {
        sideBar.classList.add('hide');
    }
})

document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav_access');
    const sections = document.querySelectorAll('section');

    navItems.forEach(item => {
        item.addEventListener('click', function() {
            const sectionId = item.getAttribute('data-section');
            console.log('Clicked section:', sectionId); // Message de débogage

            sections.forEach(section => {
                if (section.id === sectionId) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });

            navItems.forEach(nav => {
                const link = nav.querySelector('a');
                if (nav === item) {
                    link.classList.add('active');
                    link.classList.remove('inactive');
                } else {
                    link.classList.remove('active');
                    link.classList.add('inactive');
                }
            });
        });
    });

    // Initial state
    navItems.forEach(nav => {
        const link = nav.querySelector('a');
        if (nav.classList.contains('active')) {
            link.classList.add('active');
            link.classList.remove('inactive');
        } else {
            link.classList.add('inactive');
        }
    });
});


function updateDateTime() {
    const now = new Date();
    const options = {
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit'
    };
    const formattedDateTime = now.toLocaleDateString('fr-FR', options);
    document.getElementById('datetime').textContent = formattedDateTime;
}

// Mise à jour initiale
updateDateTime();
// Mise à jour toutes les secondes
setInterval(updateDateTime, 1000);

document.addEventListener('DOMContentLoaded', () => {
    const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    let today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    const currentDay = today.getDate();

    const monthNameElement = document.getElementById('monthName');
    const yearElement = document.getElementById('year');
    const daysContainer = document.getElementById('days');

    function renderCalendar(month, year) {
        monthNameElement.textContent = monthNames[month];
        yearElement.textContent = year;

        daysContainer.innerHTML = '';

        const firstDay = new Date(year, month, 1).getDay();
        const lastDay = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            daysContainer.appendChild(emptyCell);
        }

        for (let i = 1; i <= lastDay; i++) {
            const dayCell = document.createElement('div');
            dayCell.textContent = i;
            if (i === currentDay && month === today.getMonth() && year === today.getFullYear()) {
                dayCell.classList.add('current-day');
            }
            daysContainer.appendChild(dayCell);
        }
    }

    document.getElementById('prevMonth').addEventListener('click', () => {
        if (currentMonth === 0) {
            currentMonth = 11;
            currentYear--;
        } else {
            currentMonth--;
        }
        renderCalendar(currentMonth, currentYear);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        if (currentMonth === 11) {
            currentMonth = 0;
            currentYear++;
        } else {
            currentMonth++;
        }
        renderCalendar(currentMonth, currentYear);
    });

    renderCalendar(currentMonth, currentYear);
});



// window.addEventListener('DOMContentLoaded', (event) => {
//     if (window.location.hash === '#mes-taches') {
//         document.getElementById('mes-taches').style.display = 'block'
//     }
// })

let goalCount = 0;
const goalLimit = 10;

// Load goals from local storage on page load
document.addEventListener('DOMContentLoaded', () => {
    const storedGoals = JSON.parse(localStorage.getItem(`goals_${userId}`)) || [];
    const storedCompletedGoals = JSON.parse(localStorage.getItem(`completedGoals_${userId}`)) || [];
    
    goalCount = storedGoals.length;
    updateNotification();
    storedGoals.forEach(goal => addGoal(goal.name, goal.type, goal.tasks, false));
    
    if (goalCount >= goalLimit) {
        document.getElementById('resetBtn').style.display = 'block';
    }
    
    storedCompletedGoals.forEach(goal => displayCompletedGoal(goal));

     // Observe changes in the goalsContainer to update the notification count
     const goalsContainer = document.getElementById('goalsContainer');
     const observer = new MutationObserver(() => {
         goalCount = goalsContainer.childElementCount;
         updateNotification();
     });
 
     observer.observe(goalsContainer, { childList: true });
     
});

document.getElementById('addGoalBtn').addEventListener('click', () => {
    if (goalCount < goalLimit) {
        document.getElementById('goalFormContainer').style.display = 'flex';
    } else {
        alert('Vous avez atteint la limite de 10 objectifs pour cette semaine.');
    }
});

document.getElementById('goalForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const goalName = document.getElementById('goalName').value;
    const goalType = document.getElementById('goalType').value;
    const tasks = Array.from(document.querySelectorAll('#goalForm input[name="tasks[]"]'))
        .map(input => input.value)
        .filter(task => task.trim() !== '');

    if (goalName.trim() !== '' && goalType.trim() !== '') {
        addGoal(goalName, goalType, tasks, true);
        document.getElementById('goalForm').reset();
        document.getElementById('goalFormContainer').style.display = 'none';
        goalCount++;
        if (goalCount >= goalLimit) {
            document.getElementById('resetBtn').style.display = 'block';
        }
    } else {
        alert('Veuillez remplir tous les champs obligatoires.');
    }
});

document.getElementById('completedGoalsBtn').addEventListener('click', () => {
    document.getElementById('completedGoalsFormContainer').style.display = 'flex';
});

document.getElementById('resetBtn').addEventListener('click', () => {
    goalCount = 0;
    document.getElementById('resetBtn').style.display = 'none';
    localStorage.removeItem(`goals_${userId}`);
    document.getElementById('goalsContainer').innerHTML = '';
    alert('Vous pouvez maintenant ajouter de nouveaux objectifs.');
});

function addGoal(name, type, tasks, save = true) {
    const goal = document.createElement('div');
    goal.className = `goal ${type}`;
    goal.innerHTML = `
    <h3>${name}</h3>
    <button class="toggleTasksBtn" style="border:none; cursor: pointer; background:none;  font-size:14px;"><i class="fas fa-chevron-down"></i></button>
    <button class="deleteBtn" style="display: inline-block; cursor: pointer; border:none; background:none; color:#e74c3c; font-size:14px;"><i class="fas fa-trash"></i></button>
    `;
    
    const tasksContainer = document.createElement('div');
    tasksContainer.className = 'tasks';
    tasks.forEach(task => {
        const taskDiv = document.createElement('div');
        taskDiv.innerHTML = `<input type="checkbox" class="taskCheckbox" style="margin-right: 5px;">${task}`;
        tasksContainer.appendChild(taskDiv);
    });
    goal.appendChild(tasksContainer);
    const validateBtn = document.createElement('button');
    validateBtn.textContent = 'Valider';
    validateBtn.style.display = 'inline-block';
    validateBtn.style.padding = '7px';
    validateBtn.style.border = 'none';
    validateBtn.style.borderRadius = '4px';
    validateBtn.style.backgroundColor = ' #2196F3';
    validateBtn.style.color = '#fff';
    validateBtn.style.cursor = 'pointer';
    goal.appendChild(validateBtn);
    document.getElementById('goalsContainer').appendChild(goal);

    goal.querySelector('.toggleTasksBtn').addEventListener('click', () => {
        const chevronIcon = goal.querySelector('.toggleTasksBtn i');
        if (tasksContainer.style.display === 'none' || tasksContainer.style.display === '') {
            tasksContainer.style.display = 'block';
            tasksContainer.style.maxHeight = `${tasksContainer.scrollHeight}px`;
            chevronIcon.classList.remove('fa-chevron-down');
            chevronIcon.classList.add('fa-chevron-up');
        } else {
            tasksContainer.style.display = 'none';
            tasksContainer.style.maxHeight = '0';
            chevronIcon.classList.remove('fa-chevron-up');
            chevronIcon.classList.add('fa-chevron-down');
        }
    });

    validateBtn.addEventListener('click', () => {
        if (tasks.length > 0 && Array.from(tasksContainer.querySelectorAll('.taskCheckbox')).every(checkbox => checkbox.checked)) {
            completeGoal(name, type);
            goal.remove();
            goalCount--;
            if (goalCount < goalLimit) {
                document.getElementById('resetBtn').style.display = 'none';
            }
            saveGoalsToLocalStorage();
        } else {
            alert('Toutes les tâches doivent être complétées pour valider cet objectif.');
        }
    });

    goal.querySelector('.deleteBtn').addEventListener('click', () => {
        goal.remove();
        goalCount--;
        if (goalCount < goalLimit) {
            document.getElementById('resetBtn').style.display = 'none';
        }
        saveGoalsToLocalStorage();
    });

    if (save) {
        saveGoalsToLocalStorage();
    }
}

function completeGoal(name, type) {
    const completedGoal = `${name} (${type})`;
    displayCompletedGoal(completedGoal);
    saveCompletedGoalsToLocalStorage();
}

function displayCompletedGoal(goal) {
    const completedGoalElement = document.createElement('div');
    completedGoalElement.className = 'completed-goal';
    completedGoalElement.textContent = goal;
    document.getElementById('completedGoalsList').appendChild(completedGoalElement);
}

function saveGoalsToLocalStorage() {
    const goals = [];
    document.querySelectorAll('.goal').forEach(goal => {
        const name = goal.querySelector('h3').textContent;
        const type = goal.className.split(' ')[1];
        const tasks = Array.from(goal.querySelectorAll('.tasks div')).map(taskDiv => taskDiv.textContent);
        goals.push({ name, type, tasks });
    });
    localStorage.setItem(`goals_${userId}`, JSON.stringify(goals));
}

function saveCompletedGoalsToLocalStorage() {
    const completedGoals = [];
    document.querySelectorAll('.completed-goal').forEach(goal => {
        const goalText = goal.textContent;
        completedGoals.push(goalText);
    });
    localStorage.setItem(`completedGoals_${userId}`, JSON.stringify(completedGoals));
}

document.getElementById('goalFormContainer').addEventListener('click', (e) => {
    if (e.target.id === 'goalFormContainer') {
        document.getElementById('goalFormContainer').style.display = 'none';
    }
});

document.getElementById('completedGoalsFormContainer').addEventListener('click', (e) => {
    if (e.target.id === 'completedGoalsFormContainer') {
        document.getElementById('completedGoalsFormContainer').style.display = 'none';
    }
});

function updateNotification() {
    const notificationNum = document.querySelector('.notification .num');
    if (notificationNum) {
        notificationNum.textContent = goalCount;
    } else {
        console.error('Notification element not found');
    }
}


// Search functionality

function updateGoalSuggestions() {
    const goalSuggestions = document.getElementById('goalSuggestions');
    const storedGoals = JSON.parse(localStorage.getItem(`goals_${userId}`)) || [];
    
    goalSuggestions.innerHTML = '';
    storedGoals.forEach(goal => {
        const option = document.createElement('option');
        option.value = goal.name;
        goalSuggestions.appendChild(option);
    });
}

document.getElementById('searchForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    searchGoals(searchTerm);
    document.getElementById('goalsContainer').scrollIntoView({ behavior: 'smooth' });
});

function searchGoals(searchTerm) {
    const goals = document.querySelectorAll('.goal');
    goals.forEach(goal => {
        const goalName = goal.querySelector('h3').textContent.toLowerCase();
        const goalTasks = Array.from(goal.querySelectorAll('.tasks div')).map(taskDiv => taskDiv.textContent.toLowerCase()).join(' ');

        if (goalName.includes(searchTerm) || goalTasks.includes(searchTerm)) {
            goal.style.display = 'block';
        } else {
            goal.style.display = 'none';
        }
    });
}

