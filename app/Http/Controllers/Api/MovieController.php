<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Movie::orderBy('id', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'desc' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                'errors' => $validator->errors()
            ], 422);
        }

        $movie = Movie::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Movie created successfully',
            'data' => $movie
        ], Response::HTTP_CREATED);
    }

    public function show($movie)
    {
        $movie = Movie::find($movie);
        if (!$movie) {
            return response()->json(['success' => false, 'message' => 'Movie not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $movie]);
    }

    public function update(Request $request, $movie)
    {
        $movie = Movie::find($movie);
        if (!$movie) {
            return response()->json(['success' => false, 'message' => 'Movie not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'desc' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $validator->errors()->all()),
                'errors' => $validator->errors()
            ], 422);
        }

        $movie->update($validator->validated());

        return response()->json(['success' => true, 'data' => $movie]);
    }

    public function destroy($movie)
    {
        $movie = Movie::find($movie);
        if (!$movie) {
            return response()->json(['success' => false, 'message' => 'Movie not found'], 404);
        }
        $movie->delete();
        return response()->json(['success' => true, 'message' => 'Movie deleted successfully']);
    }
}
