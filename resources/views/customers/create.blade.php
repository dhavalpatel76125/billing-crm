@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-lg">
    <h1 class="text-3xl font-extrabold mb-6 text-center text-gray-800">Create New Customer</h1>
    <div class="bg-white shadow-md rounded-lg p-8">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-gray-800 font-semibold mb-2">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('name') border-red-500 @enderror"
                    placeholder="Enter customer name" 
                    value="{{ old('name') }}" 
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="phone" class="block text-gray-800 font-semibold mb-2">Phone:</label>
                <input 
                    type="text" 
                    id="phone" 
                    name="phone" 
                    class="block w-full border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('phone') border-red-500 @enderror"
                    placeholder="Enter customer phone number" 
                    value="{{ old('phone') }}" 
                    required>
                @error('phone')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
            <button 
                type="submit" 
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200">
                Submit
            </button>
        </form>
    </div>
</div>
@endsection
