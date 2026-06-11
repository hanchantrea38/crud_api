@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Customers</h2>
        <a href="{{ route('customers.create') }}" class="bg-green-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
            + Add Customer
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
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Phone</th>
                    <th class="px-6 py-3 text-left">Gender</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($customers as $customer)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">{{ $customer->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $customer->name }}</td>
                        <td class="px-6 py-4 text-blue-600">{{ $customer->email }}</td>
                        <td class="px-6 py-4">{{ $customer->phone }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                {{ $customer->gender }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('customers.edit', $customer->id) }}" class="bg-yellow-500 text-white font-semibold py-1 px-3 rounded transition-colors">
                                Edit
                            </a>
                            <button type="button" class="bg-red-600 text-white font-semibold py-1 px-3 rounded transition-colors" data-bs-toggle="modal"
                                data-bs-target="#deleteCustomer{{ $customer->id }}">
                                Delete
                            </button>
                            @include('customers.delete')
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No customers found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
