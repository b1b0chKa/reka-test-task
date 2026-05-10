@extends('layouts.app')

@section('title', 'Задачи')

@vite(['resources/js/app.js', 'resources/js/tasks.js'])

@section('content')

<div class="card">
    <h2>Создать задачу</h2>

    <form id="task-form">

        <input
            type="text"
            name="title"
            placeholder="Название задачи"
            required
        >

        <textarea
            name="text"
            placeholder="Описание задачи"
            required
        ></textarea>

        <select name="tags[]" id="tags-select" multiple></select>

        <button type="submit">
            Создать
        </button>

    </form>
</div>

<div class="card">
    <h2>Список задач</h2>

    <div id="tasks-list"></div>
</div>

@endsection
