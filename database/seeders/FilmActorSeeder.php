<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $films = DB::table('films')->pluck('id')->toArray();
        $actors = DB::table('actors')->pluck('id')->toArray();

        foreach ($films as $film) {
            $actorCount = rand(1, 3);
            $selectedActors = array_rand($actors, $actorCount);

            foreach ((array)$selectedActors as $selectedActor) {
                DB::table('films_actors')->insert([
                    'film_id' => $film,
                    'actor_id' => $actors[$selectedActor],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
