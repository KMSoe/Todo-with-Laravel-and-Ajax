
const app = document.getElementById("app");
const task_lists = document.querySelectorAll('.task-container ul');
const uncheck_lists = document.querySelector('.uncheck-tasks .task-list');
const uncheck_list_count = document.getElementById('uncheck-list-count');
const check_lists = document.querySelector('.check-tasks .task-list');
const check_list_count = document.getElementById('check-list-count');

const todo_form = document.getElementById("todo-add-from");
const todoInput = document.getElementById("task");
const todoCheckboxes = document.querySelectorAll("input[type='checkbox']");
const deleteTodoBtns = document.querySelectorAll(".delete-btn");

// loadTodos();
function loadTodos() {
    fetch(`/tasks`, {
        method: 'GET',
        headers: {
            'content-type': 'application/json',
        },
    }).then(res => res.json())
        .then(data => {
            loadTodosUI(data.tasks);
        }).catch(err => showError(err))
}

function loadTodosUI(tasks) {
    tasks.forEach((task) => {
        addTodoUI(task)
    });
}

if (todo_form) {
    todo_form.addEventListener("submit", e => {
        e.preventDefault();
        fetch(`/tasks`, {
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                title: todoInput.value,
            }),
        }).then(res => res.json())
            .then(data => {
                if (data.success) {
                    addTodoUI(data.task);
                    uncheck_list_count.textContent = data.task_count;
                    showAlert('success', 'Task added');
                    todoInput.value = '';
                    todoInput.focus();
                    hideAlert();
                } else {
                    showValidationErrors(data.errors);
                    hideAlert();
                }
            }).catch(err => showError(err))
    });
}

function showValidationErrors(errors) {
    const ol = document.createElement('ol');
    for (const key in errors) {
        const li = document.createElement('li');
        li.textContent = errors[key];
        ol.appendChild(li);
    }

    const alert = document.createElement('div');
    alert.classList.value = `alert alert-warning`;
    alert.appendChild(ol);
    app.appendChild(alert);
}
task_lists.forEach(task_list => {
    task_list.addEventListener("click", (e) => {
        let element = e.target
        let list = e.target.parentElement
        let choice = element.getAttribute("id")
        if (choice === "check") {
            checkTodo(list.dataset.id, list);
        } else if (choice === "delete") {
            deleteTodo(list.dataset.id, list)
        }
    })
})

function deleteTodo(id, list) {
    fetch(`/tasks/${id}`, {
        method: 'DELETE',
        headers: {
            'content-type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id,
        }),
    }).then(res => res.json())
        .then(data => {
            if (data.success) {
                list.remove(list);
                data.task.checked ? check_list_count.textContent = data.task_count : uncheck_list_count.textContent = data.task_count;
                showAlert('danger', 'Task deleted');
                hideAlert();
            } else {

            }
        }).catch(err => showError(err))
}

function checkTodo(id, list) {
    fetch(`/tasks/${id}`, {
        method: 'PUT',
        headers: {
            'content-type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id,
        }),
    }).then(res => res.json())
        .then(data => {
            if (data.success) {
                list.remove(list);
                addTodoUI(data.task);
                uncheck_list_count.textContent = data.uncheck_task_count;
                check_list_count.textContent = data.check_task_count;
                uncheck_list_count.textContent = data.uncheck_task_count;
                check_list_count.textContent = data.check_task_count;

                data.task.checked ? showAlert('info', 'Task Checked') :
                    showAlert('info', 'Task Unchecked');
                hideAlert();

            } else {
                console.log(data)

            }
        }).catch(err => showError(err))
}

function addTodoUI({ id, title, checked }) {
    let li = document.createElement("li");
    li.classList.value = 'task-item d-flex';
    checked ? li.classList.add("checked") : "";
    let input = document.createElement("input");
    input.setAttribute("type", "checkbox");
    checked ? input.setAttribute("checked", "") : "";
    input.classList.value = "d-inline-block my-auto mr-2";
    input.id = 'check';
    li.appendChild(input);
    let span = document.createElement("span");
    span.classList.value = 'flex-fill my-auto';
    span.textContent = title;
    li.appendChild(span);
    let button = document.createElement("button");
    button.classList.value = "btn delete-btn d-inline-block my-auto";
    button.id = 'delete'
    button.innerHTML = "&times;";
    li.appendChild(button);
    li.dataset.id = id;

    checked ? check_lists.appendChild(li) : uncheck_lists.appendChild(li);

}

function showAlert(type, message) {
    const alert = document.createElement('div');
    alert.classList.value = `alert alert-${type}`;
    alert.textContent = message;
    app.appendChild(alert);
}

// Alert hide
function hideAlert() {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = "none";
        }, 3000);
    })
}

function showError(err) {
    showAlert('warning', err)
}