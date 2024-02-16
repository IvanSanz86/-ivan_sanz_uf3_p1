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
        <li class="list-group-item"><a href="{{ route('actors.index') }}">Listado de Actores</a></li>
        <li class="list-group-item"><a href="{{ route('actors.count') }}">Contador de Actores</a></li>
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

    <form action="{{ route('actors.listByDecade') }}" method="GET">
        <label for="decade">Selecciona una década:</label>
        <select name="decade" id="decade">
            <option value="1950">1950s</option>
            <option value="1960">1960s</option>
            <option value="1970">1970s</option>
            <option value="1980">1980s</option>
            <option value="1990">1990s</option>
            <option value="2000">2000s</option>
            <option value="2010">2010s</option>
            <option value="2020">2020s</option>
        </select>
        <button type="submit">Buscar</button>
    </form>
</div>
@endsection
