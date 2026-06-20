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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'desc' => 'required|string',
        ]);

        Movie::create($data);

        return redirect()->route('movies.index')->with('success', 'Movie created successfully.');
    }

    public function edit(string $id)
    {
        $movie = Movie::findOrFail($id);
        
        return view('movies.edit', compact('movie'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'desc' => 'required|string',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->update($data);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully.');
    }

    public function destroy(string $id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully.');
    }
}
