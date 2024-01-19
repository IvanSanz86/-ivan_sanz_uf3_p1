<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movies List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            font-family: Arial, sans-serif;
            background-color:  #D3D3D3;
        }
        header {
            height: 30%;
            background-color: #D3D3D3;
            padding: 20px 0;
            text-align: center;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
            margin-top: 30px;
            bottom: 0;
            width: 100%;
        }
        img {
            width: 100%;
            height: 100%;
        }
    </style>

</head>
<body class="container">
    <header>
        <img src="{{ asset('img/Header-buscador-y-listas.jpg') }}" alt="Header Image">
    </header>

    <div class="content">
        @yield('content')
    </div>


    <footer>
    <a href="/" style="color:white;">Ir a Home</a>
        <p>&copy; Creado por Ivan Sanz</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
