document.addEventListener('DOMContentLoaded', () => {

    if (window.location.pathname !== '/tags') {
        return;
    }

    window.api.checkAuth();

    const form = document.getElementById('tag-form');

    const tagsContainer = document.getElementById('tags-container');

    const successBox = document.getElementById('tag-success');

    const errorBox = document.getElementById('tag-error');

    function showSuccess(message) {

        successBox.innerText = message;

        successBox.classList.remove('hidden');

        setTimeout(() => {
            successBox.classList.add('hidden');
        }, 2000);
    }

    function showError(message) {

        errorBox.innerText = message;

        errorBox.classList.remove('hidden');

        setTimeout(() => {
            errorBox.classList.add('hidden');
        }, 3000);
    }

    async function loadTags() {

        tagsContainer.innerHTML = 'Загрузка...';

        const response = await fetch('/api/tags', {
            method: 'GET',
            headers: window.api.headers(),
        });

        const data = await response.json();

        if (!response.ok) {

            showError('Ошибка загрузки тегов');

            return;
        }

        renderTags(data.data);
    }

    function renderTags(tags) {

        if (!tags.length) {

            tagsContainer.innerHTML = `
                <p>
                    У вас пока нет тегов
                </p>
            `;

            return;
        }

        let html = `<div class="tags-list">`;

        tags.forEach(tag => {

            html += `
                <div class="tag-item">
                    #${tag.title}
                </div>
            `;
        });

        html += `</div>`;

        tagsContainer.innerHTML = html;
    }

    form?.addEventListener('submit', async (e) => {

        e.preventDefault();

        const formData = new FormData(form);

        const response = await fetch('/api/tags', {
            method: 'POST',
            headers: window.api.headers(),
            body: JSON.stringify({
                title: formData.get('title'),
            }),
        });

        const data = await response.json();

        if (!response.ok) {

            showError(data.message || 'Ошибка создания тега');

            return;
        }

        form.reset();

        showSuccess('Тег успешно создан');

        loadTags();
    });

    loadTags();

});
