@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl text-black pb-6">Dashboard</h1>
    <div class="flex flex-wrap gap-6">
        <!-- Invoice Card -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/3">
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
                <a href="#" class="text-blue-500 text-sm font-semibold hover:underline">View Details</a>
            </div>
        </div>

        <!-- Product Card -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/3">
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
                <a href="#" class="text-green-500 text-sm font-semibold hover:underline">View Details</a>
            </div>
        </div>

        <!-- Customer Card -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-1/3">
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
                <a href="#" class="text-yellow-500 text-sm font-semibold hover:underline">View Details</a>
            </div>
        </div>
    </div>
@endsection
