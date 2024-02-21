<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{

    /**
     * Read films from storage
     */
    public function readFilms(): array
    {
        $dbFilms = Film::all()->toArray();

        $jsonFilms = Storage::get('/public/films.json');
        $jsonFilmsArray = json_decode($jsonFilms, true);

        $films = array_merge($dbFilms, $jsonFilmsArray);

        return $films;
    }
    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = null)
    {
        $old_films = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de Pelis Antiguas (Antes de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            //foreach ($this->datasource as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }
    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }
    /**
     * Lista TODAS las películas o filtra x año o categoría.
     */
    public function listFilms($year = null, $genre = null)
    {
        $films_filtered = [];

        $title = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        //if year and genre are null
        if (is_null($year) && is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

        //list based on year or genre informed
        foreach ($films as $film) {
            if ((!is_null($year) && is_null($genre)) && $film['year'] == $year) {
                $title = "Listado de todas las pelis filtrado x año";
                $films_filtered[] = $film;
            } else if ((is_null($year) && !is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
                $title = "Listado de todas las pelis filtrado x categoria";
                $films_filtered[] = $film;
            } else if (!is_null($year) && !is_null($genre) && strtolower($film['genre']) == strtolower($genre) && $film['year'] == $year) {
                $title = "Listado de todas las pelis filtrado x categoria y año";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    /**
     * List films younger than input year
     * if year is older is going to be up
     */
    public function listFilmsByYear($year = null)
    {
        $title = "Listado de películas";
        $films = FilmController::readFilms();
        $filmOfYear = null;

        if (is_null($year)) {
            $year = 2023;
        }

        foreach ($films as $film) {
            if ($film['year'] == $year && is_null($filmOfYear)) {
                $filmOfYear = $film;
            }
        }

        if (!is_null($filmOfYear)) {
            $title .= " - Se encontró la película del año $year: " . $filmOfYear['name'];
            return view('films.list', ["films" => [$filmOfYear], "title" => $title]);
        } else {
            $title .= " - No se encontró ninguna película del año $year";
            return view('films.list', ["films" => [], "title" => $title]);
        }
    }


    /**
     * List of the films by gear
     * is going to search and join the fims that has the same genere
     */
    public function listFilmsByGenre($genre = null)
    {
        $filmsFiltered = [];
        $title = "Listado de las peliculas por genero";
        $films = FilmController::readFilms();

        if (is_null($genre)) {
            return view('films.list', ["films" => $films, "title" => $title]);
        }

        foreach ($films as $film) {
            $currentGenre = strtolower($film['genre']);

            if ($currentGenre == strtolower($genre)) {
                $filmsFiltered[$currentGenre][] = $film;
            }
        }

        if (isset($filmsFiltered[strtolower($genre)])) {
            $title = "Listado de películas filtrado por categoría: " . ucwords($genre);
            return view("films.list", ["films" => $filmsFiltered[strtolower($genre)], "title" => $title]);
        } else {
            $title = "No hay películas en la categoría: " . ucwords($genre);
            return view("films.list", ["films" => [], "title" => $title]);
        }
    }
    public function listSortFilms()
    {
        $title = "Listado de las peliculas por año de forma descendente";
        $films = FilmController::readFilms();
        usort($films, function ($a, $b) {
            return $b['year'] - $a['year'];
        });
        return view('films.list', ['films' => $films, "title" => $title]);
    }
    public function listCountFilms()
    {
        $films = FilmController::readFilms();
        $contador = count($films);
        return view('films.count', ["contador" => $contador]);
    }
    public function createFilm(Request $request)
    {
        $filmData = $request->except('_token');

        if (FilmController::isFilm($filmData['name'])) {
            return redirect('/')->with('error', 'Ya has creado esta película o ya estaba dentro.');
        }

        $film = new Film($filmData);
        $film->save();

        if ($request->has('use_json_data') && $request->input('use_json_data') === true) {
            $films = FilmController::readFilms();
            $films[] = $film->toArray();
            $films = json_encode($films);
            Storage::put('public/films.json', $films);
        }

        return redirect('/')->with('success', 'Película creada con éxito.');
    }



    public function isFilm($name): bool
    {
        $films = FilmController::readFilms();
        foreach ($films as $film) {
            if ($film['name'] == $name) {
                return true;
            }
        }
        return false;
    }
}
