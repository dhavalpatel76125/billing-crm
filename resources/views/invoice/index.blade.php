@extends('layouts.app')

@section('content')
    <div class="w-full mt-6">
        <div class="mb-4">
            <a href="{{ route('invoices.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
                Create New Invoice
            </a>
        </div>
        <div class="bg-white overflow-auto">
            <table id="invoicesTable" class="min-w-full bg-white">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ID</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Customer name</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Invoice no</th>
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Date</th>
                         <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total of products + freight</th> 
                         {{-- <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Freight</th>  --}}
                         <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Credit</th> 
                         <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Debit</th>
                         {{-- <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Total</th>  --}}
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td class="text-left py-3 px-4">{{ $invoice->id }}</td>
                            <td class="text-left py-3 px-4">{{ $invoice->customer->name }}<br>
                                {{ $invoice->customer->phone }}</td>
                            <td class="text-left py-3 px-4">{{ $invoice->invoice_number }}</td>
                            <td class="text-left py-3 px-4">{{ \Carbon\Carbon::parse($invoice->date)->format('d-m-y') }}</td>

                            <td class="text-left py-3 px-4">{{ number_format($invoice->subtotal + $invoice->freight, 2, '.', '') }}</td>
                            {{-- <td class="text-left py-3 px-4">{{ $invoice->freight }}</td> --}}
                            <td class="text-left py-3 px-4">{{ $invoice->credit }}</td>
                            <td class="text-left py-3 px-4">{{ number_format($invoice->subtotal + $invoice->freight - $invoice->credit, 2, '.', '') }}</td>
                            {{-- <td class="text-left py-3 px-4">{{ $invoice->total }}</td>  --}}
                            <td class="text-left py-3 px-4">
                                <div class="flex space-x-4">
                                    <!-- View Icon -->
                                    <a href="{{ route('invoices.show', $invoice->id) }}"
                                        class="text-blue-500 hover:text-blue-800">
                                        <i class="fas fa-eye mr-3"></i>
                                    </a>
                                    <!-- Edit Icon -->
                                    <a href="{{ route('invoices.edit', $invoice->id) }}"
                                        class="text-blue-500 hover:text-blue-800">
                                        <i class="fas fa-edit mr-3"></i>
                                    </a>

                                    <!-- Delete Icon -->
                                    <form class="inline" action="{{ route('invoices.delete', $invoice->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-800">
                                            <i class="fas fa-trash mr-3"></i>
                                        </button>
                                    </form>
                                </div>
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
            $('#invoicesTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });
        });
    </script>
@endsection
