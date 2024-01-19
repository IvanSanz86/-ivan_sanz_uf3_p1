@extends('master')

@section('content')
<div class="container">
    <h1 class="mt-4 display-4">Lista de Películas</h1>
    <ul class="list-group">
        <li class="list-group-item"><a href="/filmout/oldFilms">Películas antiguas</a></li>
        <li class="list-group-item"><a href="/filmout/newFilms">Películas nuevas</a></li>
        <li class="list-group-item"><a href="/filmout/films">Películas</a></li>
        <li class="list-group-item"><a href="/filmout/filmsByYear">Películas por año</a></li>
        <li class="list-group-item"><a href="/filmout/filmsByGenre">Películas por género</a></li>
        <li class="list-group-item"><a href="/filmout/sortFilms">Películas por año descendente</a></li>
        <li class="list-group-item"><a href="/filmout/countFilms">Contador de películas</a></li>
    </ul>

    @if(session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="mt-4 display-4">Añadir nueva película</h1>
    <form action="{{ route('createFilm') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="year">Año:</label>
            <input type="number" class="form-control" id="year" name="year" required>
        </div>

        <div class="form-group">
            <label for="genre">Género:</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>

        <div class="form-group">
            <label for="country">País:</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>

        <div class="form-group">
            <label for="duration">Duración:</label>
            <input type="number" class="form-control" id="duration" name="duration" required>
        </div>

        <div class="form-group">
            <label for="image_url">URL Imagen:</label>
            <input type="text" class="form-control" id="image_url" name="img_url" required>
        </div>

        <button type="submit" class="btn btn-secondary">Enviar</button>
    </form>
</div>
@endsection
