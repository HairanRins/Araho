<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do list app</title>
    <link rel="stylesheet" href="todo.css" type="text/css">
</head>
<body>
    <div class="container">
        <div class="todo_app">
            <h2>To-do List <img src="../img/to-do-list.png" alt=""></h2>
            <div class="row">
                <input type="text" id="input_box" placeholder="Add your text">
                <button onclick="addTask()">Add</button>
            </div>
            <ul id="list_container">
                <!-- <li class="checked">Task 1</li>
                <li>Task 2</li>
                <li>Task 3</li> -->
            </ul>
        </div>
    </div>
    <script src="JS/todo.js"></script>
</body>
</html>