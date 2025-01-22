@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl text-black pb-6">Dashboard</h1>
    <div class="flex flex-wrap gap-6">
        <!-- Invoice Card -->
        <a href="{{ route('invoices.index') }}" class="w-full sm:w-1/2 lg:w-1/3">
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-blue-500 text-white rounded-full p-3">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-bold text-gray-700">Invoice</h2>
                        <p class="text-sm text-gray-500">Manage and track invoices</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <span class="text-blue-500 text-sm font-semibold hover:underline">View Details</span>
                </div>
            </div>
        </a>

        <!-- Product Card -->
        <a href="{{ route('products.index') }}" class="w-full sm:w-1/2 lg:w-1/3">
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-green-500 text-white rounded-full p-3">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-bold text-gray-700">Product</h2>
                        <p class="text-sm text-gray-500">Add and manage products</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <span class="text-green-500 text-sm font-semibold hover:underline">View Details</span>
                </div>
            </div>
        </a>

        <!-- Customer Card -->
        <a href="{{ route('customers.index') }}" class="w-full sm:w-1/2 lg:w-1/3">
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-yellow-500 text-white rounded-full p-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-bold text-gray-700">Customer</h2>
                        <p class="text-sm text-gray-500">Manage your customers</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <span class="text-yellow-500 text-sm font-semibold hover:underline">View Details</span>
                </div>
            </div>
        </a>
    </div>
@endsection
