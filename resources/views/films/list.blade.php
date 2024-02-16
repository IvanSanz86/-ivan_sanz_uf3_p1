@extends('master')

@section('content')
<h1>{{$title}}</h1>

@if(empty($films))
    <p style="color:red;">No se ha encontrado ninguna película.</p>
@else
    <div align="center">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Año</th>
                    <th>Género</th>
                    <th>País</th>
                    <th>Duración</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($films as $film)
                    <tr>
                        <td>{{$film['name']}}</td>
                        <td>{{$film['year']}}</td>
                        <td>{{$film['genre']}}</td>
                        <td>{{$film['country']}}</td>
                        <td>{{$film['duration']}}</td>
                        <td><img src="{{$film['img_url']}}" style="width: 100px; height: 120px;" /></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
