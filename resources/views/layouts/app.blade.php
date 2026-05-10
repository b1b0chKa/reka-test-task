<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body>

<header class="header">
    <div class="container header-inner">

        <a href="/" class="logo">
            Todo App
        </a>

        <nav class="nav">

            <a href="/tasks">
                Задачи
            </a>

            <a href="/tags">
                Теги
            </a>

            <a href="/login" id="login-link">
                Войти
            </a>

            <a href="/register" id="register-link">
                Регистрация
            </a>

            <button id="logout-btn" class="logout-btn hidden">
                Выйти
            </button>

        </nav>

    </div>
</header>

<main class="container">
    @yield('content')
</main>

</body>
</html>
