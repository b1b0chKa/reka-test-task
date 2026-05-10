window.api = {
    headers() {
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
        };
    },

    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');

        window.location.href = '/login';
    },

    checkAuth() {
        if (!localStorage.getItem('token')) {
            window.location.href = '/login';
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {

    const token = localStorage.getItem('token');

    const logoutBtn = document.getElementById('logout-btn');

    if (token) {
        logoutBtn?.classList.remove('hidden');

        document.getElementById('login-link')?.classList.add('hidden');
        document.getElementById('register-link')?.classList.add('hidden');
    }

    logoutBtn?.addEventListener('click', () => {
        window.api.logout();
    });
});
