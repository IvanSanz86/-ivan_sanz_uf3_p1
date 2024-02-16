<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function listActors()
    {
        $actors = Actor::all();
        return view('actors.list', compact('actors'));
    }
    public function listActorsByDecade(Request $request)
    {
        $decade = $request->input('decade');
        $startYear = $decade;
        $endYear = $decade + 9;

        $actors = Actor::whereBetween('birthdate', [$startYear . '-01-01', $endYear . '-12-31'])->get();

        return view('actors.list', compact('actors'));
    }
    public function countActors()
    {
        $totalActors = Actor::count();
        return view('actors.count', compact('totalActors'));
    }
    public function deleteActor($id)
    {
        $actor = Actor::find($id);

        if ($actor) {
            $actor->delete();
            return response()->json(['action' => 'delete', 'status' => true]);
        } else {
            return response()->json(['action' => 'delete', 'status' => false]);
        }
    }
}
