@extends('master')

@section('content')


@if(empty($actors))
    <FONT COLOR="red">No se ha encontrado ningun actor</FONT>
@else
<div align="center">
    <h1>List of Actors</h1>
    <table border="1" class="table table-bordered table-striped text-center">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Birthdate</th>
                <th>Country</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actors as $actor)
            <tr>
                <td>{{ $actor->name }}</td>
                <td>{{ $actor->surname }}</td>
                <td>{{ $actor->birthdate }}</td>
                <td>{{ $actor->country }}</td>
                <td><img src="{{ $actor->img_url }}" alt="{{ $actor->name }}" id="imagen"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    @endif
@endsection
