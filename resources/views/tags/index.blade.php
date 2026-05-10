@extends('layouts.app')

@vite(['resources/js/app.js', 'resources/js/tags.js'])

@section('content')

<div class="card">

    <h1 class="title">
        Теги
    </h1>

    <div id="tag-success" class="success-box hidden"></div>

    <div id="tag-error" class="error-box hidden"></div>

    <form id="tag-form">

        <input
            type="text"
            name="title"
            placeholder="Название тега"
            required
        >

        <button type="submit">
            Создать тег
        </button>

    </form>

</div>

<div class="card">

    <h2 class="title">
        Список тегов
    </h2>

    <div id="tags-container">

    </div>

</div>

@endsection
