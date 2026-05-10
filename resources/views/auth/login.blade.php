@extends('layouts.app')

@vite(['resources/js/app.js', 'resources/js/auth.js'])

@section('content')

<div class="card">

    <h1 class="title">
        Вход
    </h1>

    <div id="login-error" class="error-box hidden"></div>

    <form id="login-form">

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Пароль"
            required
        >

        <button type="submit">
            Войти
        </button>

    </form>

</div>

@endsection
