document.addEventListener('DOMContentLoaded', () => {
    userIds.forEach(userId => {
        const goals = JSON.parse(localStorage.getItem(`goals_${userId}`)) || [];
        const completedGoals = JSON.parse(localStorage.getItem(`completedGoals_${userId}`)) || [];

        goals.forEach(goal => {
            addGoalToTable(userId, goal.name, goal.type, goal.tasks);
        });

        completedGoals.forEach(goal => {
            addCompletedGoalToTable(userId, goal);
        });
    });
});

function addGoalToTable(userId, name, type, tasks) {
    const table = document.getElementById('userGoalsTable').querySelector('tbody');
    const row = table.insertRow();
    row.insertCell(0).textContent = userId;
    row.insertCell(1).textContent = name;
    row.insertCell(2).textContent = type;
    row.insertCell(3).textContent = tasks.join(', ');
}

function addCompletedGoalToTable(userId, goal) {
    const table = document.getElementById('completedGoalsTable').querySelector('tbody');
    const row = table.insertRow();
    row.insertCell(0).textContent = userId;
    row.insertCell(1).textContent = goal;
}

