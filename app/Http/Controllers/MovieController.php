<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('id', 'desc')->get();

        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        Movie::create([
            'name' => $request->name,
            'date' => $request->date,
            'desc' => $request->desc,
        ]);

        return redirect('/movies');
    }

    public function edit(string $id)
    {
        $movie = Movie::find($id);
        
        return view('movies.edit', compact('movie'));
    }

    public function update(Request $request, string $id)
    {
        $movie = Movie::find($id);
        $movie->update([
            'name' => $request->name,
            'date' => $request->date,
            'desc' => $request->desc,
        ]);

        return redirect('/movies');
    }

    public function destroy(string $id)
    {
        $movie = Movie::find($id);
        $movie->delete();

        return redirect('/movies');
    }
}
