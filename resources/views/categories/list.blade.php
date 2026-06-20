@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="font-bold text-gray-900 text-3xl">Categories</h2>
            <a href="{{route('categories.create')}}" class="btn btn-primary">Create Category+</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->desc }}</td>
                        <td>
                            <a href="" data-bs-toggle="modal" data-bs-target="#showCategory{{ $category->id }}">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>
                            |
                            <a href="{{ route('categories.edit', $category->id) }}">
                                <i class="fa-solid fa-pen-to-square text-info"></i>
                            </a>
                            |
                            <a href="" data-bs-toggle="modal"
                                data-bs-target="#deleteCategory{{ $category->id }}">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                            <!-- Modal -->
                            @include('categories.show')
                            @include('categories.delete')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
