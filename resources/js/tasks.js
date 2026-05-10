document.addEventListener('DOMContentLoaded', () => {

    const token = localStorage.getItem('token');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    const taskForm = document.getElementById('task-form');
    const tasksList = document.getElementById('tasks-list');
    const tagsSelect = document.getElementById('tags-select');
    const logoutBtn = document.getElementById('logout-btn');

    let draggedElement = null;

    logoutBtn?.addEventListener('click', () => {
        localStorage.removeItem('token');
        window.location.href = '/login';
    });

    async function loadTags() {
        const res = await fetch('/api/tags', {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        });

        const data = await res.json();

        tagsSelect.innerHTML = '';

        data.data.forEach(tag => {
            const option = document.createElement('option');
            option.value = tag.id;
            option.innerText = tag.title;
            tagsSelect.appendChild(option);
        });
	}

    async function loadTasks() {
        const res = await fetch('/api/tasks', {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        });

        const data = await res.json();

        tasksList.innerHTML = '';

        data.data.forEach(task => {

            const card = document.createElement('div');
            card.classList.add('task-card');
            card.setAttribute('draggable', true);
            card.dataset.id = task.id;

            const tags = task.tags
                .map(tag => `<span class="tag">${tag.title}</span>`)
                .join('');

            card.innerHTML = `
                <h3>${task.title}</h3>
                <p>${task.text ?? ''}</p>

                <div>${tags}</div>

                <button class="delete-btn">Удалить</button>
            `;

            card.querySelector('.delete-btn')
                .addEventListener('click', async () => {

                    await fetch(`/api/tasks/${task.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`,
                        }
                    });

                    loadTasks();
                });


            card.addEventListener('dragstart', () => {
                draggedElement = card;
                card.classList.add('dragging');
            });

            card.addEventListener('dragend', () => {
                draggedElement = null;
                card.classList.remove('dragging');

                saveNewOrder();
            });

            tasksList.appendChild(card);
        });
    }

    tasksList.addEventListener('dragover', (e) => {
        e.preventDefault();

        const afterElement = getDragAfterElement(tasksList, e.clientY);

        if (afterElement == null) {
            tasksList.appendChild(draggedElement);
        } else {
            tasksList.insertBefore(draggedElement, afterElement);
        }
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.task-card:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {

            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }

        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    async function saveNewOrder() {

        const ids = [...document.querySelectorAll('.task-card')]
            .map((el, index) => ({
                id: el.dataset.id,
                position: index
            }));

        await fetch('/api/tasks/sort', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify({ tasks: ids })
        });
    }

    taskForm?.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(taskForm);

        const selectedTags = [...tagsSelect.selectedOptions]
            .map(o => Number(o.value));

        await fetch('/api/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            },
            body: JSON.stringify({
                title: formData.get('title'),
                text: formData.get('text'),
                tags: selectedTags,
            })
        });

        taskForm.reset();
        loadTasks();
    });

    loadTags();
    loadTasks();
});
