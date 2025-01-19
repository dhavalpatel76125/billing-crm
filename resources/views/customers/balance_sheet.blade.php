@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-7xl">
    <h1 class="text-3xl font-bold text-center text-purple-700 mb-8">Balance Sheet</h1>
    <div class="bg-white shadow-lg rounded-lg p-8">
        <table id="balanceSheetTable" class="min-w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">Customer Name</th>
                    <th class="border px-4 py-2">Phone</th>
                    <th class="border px-4 py-2">Total Credit</th>
                    <th class="border px-4 py-2">Total Debit</th>
                    <th class="border px-4 py-2">Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($balanceSheets as $balance)
                <tr>
                    <td class="border px-4 py-2">{{ $balance->customer->name }}</td>
                    <td class="border px-4 py-2">{{ $balance->customer->phone }}</td>
                    <td class="border px-4 py-2">₹{{ number_format($balance->total_credit, 2) }}</td>
                    <td class="border px-4 py-2">₹{{ number_format($balance->total_debit, 2) }}</td>
                    <td class="border px-4 py-2">₹{{ number_format($balance->balance, 2) }}</td>
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
        $('#balanceSheetTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true
        });
    });
</script>
@endsection
