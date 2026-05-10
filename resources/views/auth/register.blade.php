@extends('layouts.app')

@section('content')

<div class="card">

    <h1 class="title">
        Регистрация
    </h1>

    <div id="register-error" class="error-box hidden"></div>

    <form id="register-form">

        <input
            type="text"
            name="name"
            placeholder="Имя"
            required
        >

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

        <input
            type="password"
            name="password_confirmation"
            placeholder="Подтверждение пароля"
            required
        >

        <button type="submit">
            Зарегистрироваться
        </button>

    </form>

</div>

@endsection
