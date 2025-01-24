@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="bg-blue-700 text-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Invoice</h1>
                <div>
                    <button onclick="printInvoice()" class="bg-white hover:bg-blue-600 text-black font-bold py-2 px-4 rounded-lg">
                        Print
                    </button>
                </div>
            </div>
            <div class="mt-2">
                <p>#{{ $invoice->invoice_number }} | {{ \Carbon\Carbon::parse($invoice->created_at)->format('F d, Y g:i a') }}</p>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-8 mt-6" id="print-section">
            <div class="text-left mb-8">
                {{-- <img src="/path-to-your-logo.png" alt="Logo" class="mx-auto mb-4" style="max-width: 100px;"> --}}
                <h1 class="text-2xl font-bold text-gray-800">Bhavani Traders</h1>
                <p>All Kind of Building Materials are Available</p>
                <p>Nr. Hariya College, Indira Marg Road, Jamnagar.</p>
                <p>Mo. 97148 28216, 93755 26050</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="font-bold text-lg text-gray-800">Invoice To:</h2>
                    <p>{{ $invoice->customer->name }}</p>
                    <p>Phone: {{ $invoice->customer->phone }}</p>
                </div>
                <div>
                    <p><strong>Invoice#:</strong> {{ $invoice->invoice_number }}</p>

                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d-m-y') }}</p>


                    <p><strong>Reference:</strong> {{ $invoice->reference ?? 'N/A' }}</p>


                    <p><strong>Vehicle:</strong> {{ $invoice->vehicle_number ?? 'N/A' }}</p>
                </div>
            </div>

            <table class="min-w-full border-collapse border border-gray-300 mb-6">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2">Item Name</th>
                        <th class="border px-4 py-2">Item Description</th>
                        <th class="border px-4 py-2">Qty</th>
                        <th class="border px-4 py-2">Unit Price</th>
                        <th class="border px-4 py-2 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->invoiceItems as $index => $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">{{ $item->product->name }}</td>
                            <td class="border px-4 py-2">{{ $item->description }}</td>
                            <td class="border px-4 py-2">{{ $item->quantity }}</td>
                            <td class="border px-4 py-2">₹{{ number_format($item->unit_price, 2) }}</td>
                            <td class="border px-4 py-2 text-right">₹{{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mb-8">
                <p><strong>Sub Total:</strong> ₹{{ number_format($invoice->subtotal, 2) }}</p>
                <p><strong>Freight:</strong> ₹{{ number_format($invoice->freight, 2) }}</p>
                {{-- <p><strong>Total of product and freight:</strong> ₹{{ number_format($invoice->subtotal + $invoice->freight, 2) }}</p>
                <p><strong>Credited amount:</strong> ₹{{ number_format($invoice->credit, 2) }}</p> --}}
                <p><strong>Total amount:</strong> ₹{{ number_format($invoice->grand_total, 2) }}</p>
            </div>

            <div class="text-center">
                <p class="font-semibold">Thank you for your business</p>
            </div>

            {{-- <div class="mt-6">
                <h3 class="text-lg font-semibold">Terms and Conditions</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
            </div> --}}
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-section, #print-section * {
                visibility: visible;
            }
            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

    <script>
        function printInvoice() {
            const originalTitle = document.title;
            document.title = 'Invoice_{{ $invoice->invoice_number }}';
            window.print();
            document.title = originalTitle;
        }
    </script>
@endsection
