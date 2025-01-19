@extends('layouts.app')

@section('content')
<div class="w-full mt-6">
    <div class="mb-4">
        <a href="{{ route('customers.create') }}" 
           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
            Create New Customer
        </a>
    </div>
    <div class="bg-white overflow-auto">
        <table id="customersTable" class="min-w-full bg-white">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Phone</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total Transactions</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Edit</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Delete</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($customers as $customer)
                <tr>
                    <td class="text-left py-3 px-4">{{ $customer->id }}</td>
                    <td class="text-left py-3 px-4">{{ $customer->name }}</td>
                    <td class="text-left py-3 px-4">{{ $customer->phone }}</td>
                    <td class="text-left py-3 px-4">
                        <a href="{{ route('customers.transactions', $customer->id) }}" class="text-blue-500 hover:text-blue-800">
                            Click to view
                        </a>
                    </td>                       
                    <td class="text-left py-3 px-4">
                        <a href="{{ route('customers.edit', $customer->id) }}" class="text-blue-500 hover:text-blue-800">
                            Edit
                        </a>
                    </td>
                    <td class="text-left py-3 px-4">
                        <form class="inline" action="{{ route('customers.delete', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-800">Delete</button>
                        </form>
                    </td>
                    
                </tr>
                @endforeach 
            </tbody>
        </table>
    </div>
</div>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#customersTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true
        });
    });
</script>
@endsection
