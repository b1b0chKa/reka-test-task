document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById('login-form');

    loginForm?.addEventListener('submit', async (e) => {

        e.preventDefault();

        const errorBox = document.getElementById('login-error');

        errorBox.classList.add('hidden');

        const formData = new FormData(loginForm);

        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                email: formData.get('email'),
                password: formData.get('password'),
            })
        });

        const data = await response.json();

        if (!response.ok || !data.status) {

            errorBox.innerText = data.message || 'Ошибка авторизации';

            errorBox.classList.remove('hidden');

            return;
        }

        localStorage.setItem('token', data.data.token);

        localStorage.setItem('user', JSON.stringify(data.data));

        window.location.href = '/tasks';
    });

    const registerForm = document.getElementById('register-form');

    registerForm?.addEventListener('submit', async (e) => {

        e.preventDefault();

        const errorBox = document.getElementById('register-error');

        errorBox.classList.add('hidden');

        const formData = new FormData(registerForm);

        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation'),
            })
        });

        const data = await response.json();

        if (!response.ok || !data.status) {

            errorBox.innerText = data.message || 'Ошибка регистрации';

            errorBox.classList.remove('hidden');

            return;
        }

        window.location.href = '/login';
    });

});
