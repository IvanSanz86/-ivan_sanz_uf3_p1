@extends('master')

@section('content')
<h1>{{$title}}</h1>

@if(empty($films))
    <FONT COLOR="red">No se ha encontrado ninguna película</FONT>
@else
    <div align="center">
    <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
            @foreach($films as $film)
                @foreach(array_keys($film) as $key)
                    <th>{{$key}}</th>
                @endforeach
                @break
            @endforeach
        </tr>
        </thead>
        @foreach($films as $film)
            <tr>
                <td>{{$film['name']}}</td>
                <td>{{$film['year']}}</td>
                <td>{{$film['genre']}}</td>
                <td>{{$film['country']}}</td>
                <td>{{$film['duration']}}</td>
                <td><img src={{$film['img_url']}} style="width: 100px; heigth: 120px;" /></td>
            </tr>
        @endforeach
    </table>
</div>
@endif
@endsection