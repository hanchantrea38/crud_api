@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">

    <!-- Hero Section -->
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">Welcome to Laravel CRUD API</h1>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Categories Card -->
            <a href="{{ route('categories.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Categories</h2>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200">
                        Go to Categories
                    </button>
                </div>
            </a>

            <!-- Products Card -->
            <a href="{{ route('products.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Products</h2>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200">
                        Go to Products
                    </button>
                </div>
            </a>

            <!-- Customers Card -->
            <a href="{{ route('customers.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Customers</h2>
                    <button class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200">
                        Go to Customers
                    </button>
                </div>
            </a>

            <!-- Movies Card -->
            <a href="{{ route('movies.index') }}" class="group">
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-3">Movies</h2>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors duration-200">
                        Go to Movies
                    </button>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
