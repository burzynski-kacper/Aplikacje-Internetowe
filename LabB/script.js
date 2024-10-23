function addTask() {
    const value = document.getElementById("newTaskValue");
    const date = document.getElementById("newTaskDate");

    if (value.value.length < 3 || value.value.length > 255) {
        alert("Zła długość taska");
        return;
    }

    const theDay = new Date(date.value);
    const today = new Date();
    today.setHours(0, 0, 0);

    if (date.value && theDay < today) {
        alert("Zła data");
        return;
    }

    const task = {
        text: value.value,
        date: date.value || "Brak daty"
    };

    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks.push(task);
    localStorage.setItem("tasks", JSON.stringify(tasks));

    displayTasks();
}

function deleteTask(index) {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks.splice(index, 1);
    localStorage.setItem("tasks", JSON.stringify(tasks));
    displayTasks();
}

//SearchBar
document.getElementById("searchBar").addEventListener("input", function() {
    const query = this.value.toLowerCase();
    if (query.length >= 2) {
        displayTasks(query);
    } else {
        displayTasks();
    }
});

function displayTasks(query = "") {
    const taskList = document.getElementById("toDoList");
    taskList.innerHTML = "";

    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

    tasks.forEach((task, index) => {
        const taskTextLower = task.text.toLowerCase();

        if (query && !taskTextLower.includes(query)) {
            return;
        }

        const newDiv = document.createElement("div");
        const newSpanText = document.createElement("span");
        const newSpanDate = document.createElement("span");
        const deleteButton = document.createElement("input");

        if (query) {
            const regex = new RegExp(`(${query})`, 'gi');
            newSpanText.innerHTML = task.text.replace(regex, `<strong style="color: #ffcc00;">$1</strong>`);
        } else {
            newSpanText.textContent = task.text;
        }

        newSpanDate.textContent = task.date;
        deleteButton.type = "button";
        deleteButton.value = "X";
        deleteButton.className = "deleteButton";

        newDiv.className = "singleTask";
        newSpanText.className = "taskValue";
        newSpanDate.className = "taskDateValue";

        newSpanText.addEventListener("click", () => editTaskText(index, newSpanText));
        newSpanDate.addEventListener("click", () => editTaskDate(index, newSpanDate));

        newDiv.appendChild(newSpanText);
        newDiv.appendChild(newSpanDate);
        newDiv.appendChild(deleteButton);

        deleteButton.addEventListener("click", () => deleteTask(index));

        taskList.appendChild(newDiv);
    });
}

function editTaskText(index, spanText) {
    const currentText = spanText.textContent;
    const input = document.createElement("input");
    input.type = "text";
    input.value = currentText;
    spanText.innerHTML = "";
    spanText.appendChild(input);

    input.addEventListener("blur", () => {
        const newText = input.value.trim();
        if (newText.length < 3 || newText.length > 255) {
            alert("Zła długość taska");
            spanText.textContent = currentText;
        } else {
            let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
            tasks[index].text = newText;
            localStorage.setItem("tasks", JSON.stringify(tasks));
            displayTasks();
        }
    });

    input.focus();
}

function editTaskDate(index, spanDate) {
    const currentDate = spanDate.textContent;
    const input = document.createElement("input");
    input.type = "date";
    input.value = currentDate === "Brak daty" ? "" : currentDate;
    spanDate.innerHTML = "";
    spanDate.appendChild(input);

    input.addEventListener("blur", () => {
        const newDate = input.value;
        let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
        if (newDate && new Date(newDate) < new Date()) {
            alert("Zła data");
            spanDate.textContent = currentDate;
        } else {
            tasks[index].date = newDate || "Brak daty";
            localStorage.setItem("tasks", JSON.stringify(tasks));
            displayTasks();
        }
    });

    input.focus();
}

document.getElementById("newTaskSubmit").addEventListener("click", addTask);

//LoadTasks
document.addEventListener("DOMContentLoaded", () => {
    displayTasks();
});
