@extends('layouts.app')

@section('content')

<div class="card">

    <h1 class="title">
        Todo App
    </h1>

    <p>
        Простое приложение для управления задачами.
    </p>

    <br>

    <a href="/login">
        <button>
            Войти
        </button>
    </a>

    <br><br>

    <a href="/register">
        <button>
            Регистрация
        </button>
    </a>

</div>

@endsection
