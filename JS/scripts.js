document.getElementById('addTaskBtn').addEventListener('click', function() {
    var formContainer = document.getElementById('addTaskFormContainer');
    formContainer.style.display = 'block';
});

var closeButtons = document.getElementsByClassName('close');
for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].addEventListener('click', function() {
        var formContainer = this.closest('.modal');
        formContainer.style.display = 'none';
    });
}

window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

document.getElementById('addTaskBtn').addEventListener('click', function() {
    var formContainer = document.getElementById('addTaskFormContainer');
    formContainer.style.display = 'block';
});

var closeButtons = document.getElementsByClassName('close');
for (var i = 0; i < closeButtons.length; i++) {
    closeButtons[i].addEventListener('click', function() {
        var formContainer = this.closest('.modal');
        formContainer.style.display = 'none';
    });
}

window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
});

var editButtons = document.getElementsByClassName('editBtn');
for (var i = 0; i < editButtons.length; i++) {
    editButtons[i].addEventListener('click', function() {
        var taskId = this.getAttribute('data-id');
        var userId = document.querySelector('input[name="user_id"]').value; // Assurez-vous que cet élément existe
        fetch('get_task.php?id=' + taskId + '&user_id=' + userId)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('editTaskId').value = data.id;
                    document.getElementById('editStatus').value = data.status;
                    document.getElementById('editPriority').value = data.priority;
                    document.getElementById('editName').value = data.name;
                    document.getElementById('editDescription').value = data.description;
                    document.getElementById('editDueDate').value = data.due_date;
                    document.getElementById('editTaskFormContainer').style.display = 'block';
                } else {
                    alert('Tâche non trouvée ou vous n\'avez pas la permission de la modifier.');
                }
            });
    });
}
