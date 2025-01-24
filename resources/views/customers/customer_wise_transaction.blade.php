@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <!-- Customer Details Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-purple-700">Customer Transactions</h1>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-lg"><strong>Name:</strong> {{ $customer->name }}</p>
                        <p class="text-lg"><strong>Phone:</strong> {{ $customer->phone }}</p>
                    </div>
                    <div class="text-right" hidden>
                        <p class="text-lg"><strong>Total Credit:</strong> ₹{{ number_format($totalCredit, 2) }}</p>
                        <p class="text-lg"><strong>Total Debit:</strong> ₹{{ number_format($totalDebit, 2) }}</p>
                        <p class="text-lg font-bold"><strong>Balance:</strong> ₹{{ number_format($balance, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="overflow-x-auto">
                <table id="transactionsTable" class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-semibold">Invoice No</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-left text-sm font-semibold">Date</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-right text-sm font-semibold">Product Total +
                                Freight</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-right text-sm font-semibold">Credit</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-right text-sm font-semibold">Debit</th>
                            <th class="px-6 py-3 border-b border-gray-300 text-center text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 border-b border-gray-300">{{ $transaction->invoice_number }}</td>
                                <td class="px-6 py-4 border-b border-gray-300">
                                    {{ date('d-m-Y', strtotime($transaction->date)) }}</td>

                                <td class="px-6 py-4 border-b border-gray-300 text-right">
                                    ₹{{ number_format($transaction->subtotal + $transaction->freight, 2) }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-right">
                                    ₹{{ number_format($transaction->credit, 2) }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-right">
                                    ₹{{ number_format($transaction->grand_total, 2) }}</td>
                                <td class="px-6 py-4 border-b border-gray-300 text-center">
                                    <a href="{{ route('invoices.show', $transaction->id) }}"
                                        class="text-blue-500 hover:text-blue-700 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $transaction->id) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                order: [
                    [1, 'desc']
                ], // Sort by date column descending
                columnDefs: [
                    {
                        targets: [2, 3, 4], // Numeric columns
                        className: 'text-right' // Ensure right alignment for amounts
                    },
                    {
                        targets: [5], // Actions column
                        orderable: false,
                        className: 'text-center' // Center align actions
                    }
                ]
            });
        });
    </script>
    
@endsection
