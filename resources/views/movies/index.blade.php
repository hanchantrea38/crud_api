@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Movies</h2>
        <a href="{{ route('movies.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
            + Add Movie
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ $message }}
        </div>
    @endif

    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Release Date</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($movies as $movie)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">{{ $movie->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $movie->name }}</td>
                        <td class="px-6 py-4">{{ $movie->date }}</td>
                        <td class="px-6 py-4 text-gray-600 truncate">{{ substr($movie->desc, 0, 50) }}...</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('movies.edit', $movie->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded transition-colors">
                                Edit
                            </a>
                            <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded transition-colors" data-bs-toggle="modal"
                                data-bs-target="#deleteMovie{{ $movie->id }}">
                                Delete
                            </button>
                            @include('movies.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No movies found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
