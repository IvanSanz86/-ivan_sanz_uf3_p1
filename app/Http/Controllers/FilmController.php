<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Film;

class FilmController extends Controller
{
     /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = 2000)
    {
        $title = "Listado de Pelis Antiguas (Antes de $year)";
        $old_films = Film::where('year', '<', $year)->get();

        return view('films.list', compact('old_films', 'title'));
    }

    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = 2000)
    {
        $title = "Listado de Pelis Nuevas (Después de $year)";
        $new_films = Film::where('year', '>=', $year)->get();

        return view('films.list', compact('new_films', 'title'));
    }

    /**
     * Lista TODAS las películas o filtra x año o categoría.
     */
    public function listFilms($year = null, $genre = null)
    {
        $title = "Listado de todas las pelis";

        $filmsQuery = Film::query();

        if (!is_null($year)) {
            $filmsQuery->where('year', $year);
            $title = "Listado de todas las pelis filtrado por año";
        }

        if (!is_null($genre)) {
            $filmsQuery->where('genre', 'like', "%$genre%");
            $title = "Listado de todas las pelis filtrado por género";
        }

        $films = $filmsQuery->get();

        return view("films.list", compact('films', 'title'));
    }

    /**
     * List films younger than input year
     * if year is older is going to be up
     */
    public function listFilmsByYear($year = 2023)
    {
        $film = Film::where('year', $year)->first();

        if ($film) {
            $title = "Listado de películas - Se encontró la película del año $year: " . $film->name;
            return view('films.list', compact('film', 'title'));
        } else {
            $title = "Listado de películas - No se encontró ninguna película del año $year";
            return view('films.list', compact('title'));
        }
    }

    /**
     * List of the films by genre
     * is going to search and join the films that has the same genre
     */
    public function listFilmsByGenre($genre = null)
    {
        $title = "Listado de las películas por género";
        
        if (!is_null($genre)) {
            $films = Film::where('genre', 'like', "%$genre%")->get();
            $title = "Listado de películas filtrado por categoría: " . ucwords($genre);
        } else {
            $films = Film::all();
        }

        return view("films.list", compact('films', 'title'));
    }

    /**
     * List films sorted by year in descending order
     */
    public function listSortFilms()
    {
        $title = "Listado de las películas por año de forma descendente";
        $films = Film::orderBy('year', 'desc')->get();

        return view('films.list', compact('films', 'title'));
    }

    /**
     * Count films
     */
    public function listCountFilms()
    {
        $title = "Conteo de películas";
        $contador = Film::count();

        return view('films.count', compact('contador', 'title'));
    }

    /**
     * Create a film
     */
    public function createFilm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'year' => 'required|numeric',
            'genre' => 'required',
            // Add validation rules for other fields as needed
        ]);

        Film::create($validatedData);

        return redirect('/')->with('success', 'Película creada con éxito.');
    }
    // /**
    //  * Read films from storage
    //  */
    // public function readFilms(): array
    // {
    //     $dbFilms = Film::all()->toArray();

    //     $jsonFilms = Storage::get('/public/films.json');
    //     $jsonFilmsArray = json_decode($jsonFilms, true);

    //     $films = array_merge($dbFilms, $jsonFilmsArray);

    //     return $films;
    // }
    // /**
    //  * List films older than input year 
    //  * if year is not infomed 2000 year will be used as criteria
    //  */
    // public function listOldFilms($year = null)
    // {
    //     $old_films = [];
    //     if (is_null($year))
    //         $year = 2000;

    //     $title = "Listado de Pelis Antiguas (Antes de $year)";
    //     $films = FilmController::readFilms();

    //     foreach ($films as $film) {
    //         //foreach ($this->datasource as $film) {
    //         if ($film['year'] < $year)
    //             $old_films[] = $film;
    //     }
    //     return view('films.list', ["films" => $old_films, "title" => $title]);
    // }
    // /**
    //  * List films younger than input year
    //  * if year is not infomed 2000 year will be used as criteria
    //  */
    // public function listNewFilms($year = null)
    // {
    //     $new_films = [];
    //     if (is_null($year))
    //         $year = 2000;

    //     $title = "Listado de Pelis Nuevas (Después de $year)";
    //     $films = FilmController::readFilms();

    //     foreach ($films as $film) {
    //         if ($film['year'] >= $year)
    //             $new_films[] = $film;
    //     }
    //     return view('films.list', ["films" => $new_films, "title" => $title]);
    // }
    // /**
    //  * Lista TODAS las películas o filtra x año o categoría.
    //  */
    // public function listFilms($year = null, $genre = null)
    // {
    //     $films_filtered = [];

    //     $title = "Listado de todas las pelis";
    //     $films = FilmController::readFilms();

    //     //if year and genre are null
    //     if (is_null($year) && is_null($genre))
    //         return view('films.list', ["films" => $films, "title" => $title]);

    //     //list based on year or genre informed
    //     foreach ($films as $film) {
    //         if ((!is_null($year) && is_null($genre)) && $film['year'] == $year) {
    //             $title = "Listado de todas las pelis filtrado x año";
    //             $films_filtered[] = $film;
    //         } else if ((is_null($year) && !is_null($genre)) && strtolower($film['genre']) == strtolower($genre)) {
    //             $title = "Listado de todas las pelis filtrado x categoria";
    //             $films_filtered[] = $film;
    //         } else if (!is_null($year) && !is_null($genre) && strtolower($film['genre']) == strtolower($genre) && $film['year'] == $year) {
    //             $title = "Listado de todas las pelis filtrado x categoria y año";
    //             $films_filtered[] = $film;
    //         }
    //     }
    //     return view("films.list", ["films" => $films_filtered, "title" => $title]);
    // }

    // /**
    //  * List films younger than input year
    //  * if year is older is going to be up
    //  */
    // public function listFilmsByYear($year = null)
    // {
    //     $title = "Listado de películas";
    //     $films = FilmController::readFilms();
    //     $filmOfYear = null;

    //     if (is_null($year)) {
    //         $year = 2023;
    //     }

    //     foreach ($films as $film) {
    //         if ($film['year'] == $year && is_null($filmOfYear)) {
    //             $filmOfYear = $film;
    //         }
    //     }

    //     if (!is_null($filmOfYear)) {
    //         $title .= " - Se encontró la película del año $year: " . $filmOfYear['name'];
    //         return view('films.list', ["films" => [$filmOfYear], "title" => $title]);
    //     } else {
    //         $title .= " - No se encontró ninguna película del año $year";
    //         return view('films.list', ["films" => [], "title" => $title]);
    //     }
    // }


    // /**
    //  * List of the films by gear
    //  * is going to search and join the fims that has the same genere
    //  */
    // public function listFilmsByGenre($genre = null)
    // {
    //     $filmsFiltered = [];
    //     $title = "Listado de las peliculas por genero";
    //     $films = FilmController::readFilms();

    //     if (is_null($genre)) {
    //         return view('films.list', ["films" => $films, "title" => $title]);
    //     }

    //     foreach ($films as $film) {
    //         $currentGenre = strtolower($film['genre']);

    //         if ($currentGenre == strtolower($genre)) {
    //             $filmsFiltered[$currentGenre][] = $film;
    //         }
    //     }

    //     if (isset($filmsFiltered[strtolower($genre)])) {
    //         $title = "Listado de películas filtrado por categoría: " . ucwords($genre);
    //         return view("films.list", ["films" => $filmsFiltered[strtolower($genre)], "title" => $title]);
    //     } else {
    //         $title = "No hay películas en la categoría: " . ucwords($genre);
    //         return view("films.list", ["films" => [], "title" => $title]);
    //     }
    // }
    // public function listSortFilms()
    // {
    //     $title = "Listado de las peliculas por año de forma descendente";
    //     $films = FilmController::readFilms();
    //     usort($films, function ($a, $b) {
    //         return $b['year'] - $a['year'];
    //     });
    //     return view('films.list', ['films' => $films, "title" => $title]);
    // }
    // public function listCountFilms()
    // {
    //     $films = FilmController::readFilms();
    //     $contador = count($films);
    //     return view('films.count', ["contador" => $contador]);
    // }
    // public function createFilm(Request $request)
    // {
    //     $filmData = $request->except('_token');

    //     if (FilmController::isFilm($filmData['name'])) {
    //         return redirect('/')->with('error', 'Ya has creado esta película o ya estaba dentro.');
    //     }

    //     $film = new Film($filmData);
    //     $film->save();

    //     if ($request->has('use_json_data') && $request->input('use_json_data') === true) {
    //         $films = FilmController::readFilms();
    //         $films[] = $film->toArray();
    //         $films = json_encode($films);
    //         Storage::put('public/films.json', $films);
    //     }

    //     return redirect('/')->with('success', 'Película creada con éxito.');
    // }



    // public function isFilm($name): bool
    // {
    //     $films = FilmController::readFilms();
    //     foreach ($films as $film) {
    //         if ($film['name'] == $name) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
}
