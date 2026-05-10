<!DOCTYPE html>
<html>
<head>
    <title>Tasks App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<header class="header">
    <a href="/">Home</a>
    <a href="/tasks">Tasks</a>
    <a href="/tags">Tags</a>
    <a href="/login" id="logout-link">Logout</a>
</header>

<div class="container">
    @yield('content')
</div>

<div id="error-box" style="color:red; display:none;"></div>

</body>
</html>
