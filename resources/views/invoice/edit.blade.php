@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-7xl">
    <h1 class="text-3xl font-bold text-center text-purple-700 mb-8">Edit Invoice</h1>
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="bg-white shadow-lg rounded-lg p-8">
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- Customer and Invoice Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="customer" class="block text-gray-800 font-semibold mb-2">Customer</label>
                    <select id="customerdropdown" name="customer" class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>Name: {{ $customer->name }} | Phone: {{ $customer->phone }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date" class="block text-gray-800 font-semibold mb-2">Date</label>
                    <input type="date" id="date" name="date" value="{{ $invoice->date }}" class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label for="reference" class="block text-gray-800 font-semibold mb-2">Reference (Optional)</label>
                    <input type="text" id="reference" name="reference" value="{{ $invoice->reference }}" class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="vehicle_number" class="block text-gray-800 font-semibold mb-2">Vehicle Number (Optional)</label>
                    <input type="text" id="vehicle_number" name="vehicle_number" value="{{ $invoice->vehicle_number }}" class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Invoice Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 border">Product</th>
                            {{-- <th class="px-6 py-3 border">Description</th> --}}
                            <th class="px-6 py-3 border">Quantity</th>
                            <th class="px-6 py-3 border">Unit Price</th>
                            <th class="px-6 py-3 border">Total</th>
                            <th class="px-6 py-3 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-table-body">
                        @foreach ($invoice->invoiceItems as $item)
                        <tr>
                            <td class="px-6 py-3 border w-2/5">
                                <select name="product_id[]" class="productdropdown w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" disabled>Select a product</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} - {{ $product->description }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-3 border w-1/5" hidden>
                                <textarea name="description[]" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $item->description }}</textarea>
                            </td>
                            <td class="px-6 py-3 border w-1/6">
                                <input type="number" name="quantity[]" value="{{ $item->quantity }}" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="updateTotals()">
                            </td>
                            <td class="px-6 py-3 border w-1/6">
                                <input type="number" name="unit_price[]" value="{{ $item->unit_price }}" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="updateTotals()">
                            </td>
                            <td class="px-6 py-3 border w-1/6 text-right">
                                <span class="item-total">₹{{ number_format($item->total, 2) }}</span>
                                <input type="hidden" name="total[]" value="{{ $item->total }}">
                            </td>
                            <td class="px-6 py-3 border w-1/12 text-center">
                                <button type="button" onclick="removeLine(this)" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" onclick="addNewLine()" class="bg-green-500 text-white py-2 px-4 rounded mt-4 hover:bg-green-600">Add New Line</button>
            </div>

            <!-- Totals Section -->
            <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow">
                <div class="flex justify-between items-center font-medium text-lg">
                    <span>Sub Total:</span>
                    <span id="sub-total">₹{{ number_format($invoice->subtotal, 2) }}</span>
                    <input type="hidden" id="product-total-for-hidden" name="product-total-for-hidden" value="{{ $invoice->subtotal }}">
                </div>
                <div class="flex justify-between items-center mb-4">
                    <label for="freight" class="text-gray-800 font-medium">Freight:</label>
                    <input type="number" id="freight" name="freight" value="{{ $invoice->freight }}" class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-blue-600" onchange="updateTotals()">
                </div>
                <div class="flex justify-between items-center font-medium text-lg">
                    <span>Total of Product & Freight:</span>
                    <span id="total-of-product-and-freight">₹{{ number_format($invoice->subtotal + $invoice->freight, 2) }}</span>
                    <input type="hidden" id="total-of-product-and-freight-for-hidden" name="total-of-product-and-freight-for-hidden" step="0.01" value="{{ $invoice->subtotal + $invoice->freight }}">
                </div>
                <div class="flex justify-between items-center mb-4">
                    <label for="credit" class="text-gray-800 font-medium">Credit (Received):</label>
                    <input type="number" id="credit" name="credit" value="{{ $invoice->credit }}" class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-red-700" step="0.01" onchange="updateTotals()">
                </div>
                <div class="flex justify-between items-center font-medium text-lg">
                    <span>Grand Total (After Credit):</span>
                    <span id="grand-total">₹{{ number_format($invoice->total, 2) }}</span>
                    <input type="hidden" id="grand-total-for-hidden" name="grand-total-for-hidden" value="{{ $invoice->total }}">
                </div>
            </div>
            <button type="submit" class="mt-8 w-full bg-blue-500 text-white py-3 rounded shadow-md hover:bg-blue-600">Update Invoice</button>
        </form>
    </div>
</div>

<script>
function updateTotals() {
    const tableBody = document.getElementById('invoice-table-body');
    const rows = tableBody.querySelectorAll('tr');
    let subTotal = 0;

    rows.forEach(row => {
        const unitPrice = Math.max(0, parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0);
        const quantity = Math.max(0, parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0);
        const total = unitPrice * quantity;

        row.querySelector('input[name="total[]"]').value = total;
        row.querySelector('.item-total').textContent = `₹${total.toFixed(2)}`;
        subTotal += total;
    });

    const freight = Math.max(0, parseFloat(document.getElementById('freight').value) || 0);
    const credit = Math.max(0, parseFloat(document.getElementById('credit').value) || 0);
    const totalOfProductAndFreight = subTotal + freight;
    const grandTotal = totalOfProductAndFreight - credit;

    document.getElementById('sub-total').textContent = `₹${subTotal.toFixed(2)}`;
    document.getElementById('product-total-for-hidden').value = subTotal;

    document.getElementById('total-of-product-and-freight').textContent = `₹${totalOfProductAndFreight.toFixed(2)}`;
    document.getElementById('total-of-product-and-freight-for-hidden').value = totalOfProductAndFreight;

    document.getElementById('grand-total').textContent = `₹${grandTotal.toFixed(2)}`;
    document.getElementById('grand-total-for-hidden').value = grandTotal;
}

function removeLine(button) {
    const row = button.closest('tr');
    row.remove();
    updateTotals();
}

function addNewLine() {
    const tableBody = document.getElementById('invoice-table-body');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="px-6 py-3 border w-2/5">
            <select name="product_id[]" class="productdropdown w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Select a product</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->description }}</option>
                @endforeach
            </select>
        </td>
        <td class="px-6 py-3 border w-1/5" hidden>
            <textarea name="description[]" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
        </td>
        <td class="px-6 py-3 border w-1/6">
            <input type="number" name="quantity[]" value="" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" onchange="updateTotals()">
        </td>
        <td class="px-6 py-3 border w-1/6">
            <input type="number" name="unit_price[]" value="" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" step="0.01" onchange="updateTotals()">
        </td>
        <td class="px-6 py-3 border w-1/6 text-right">
            <span class="item-total">₹0.00</span>
            <input type="hidden" name="total[]" value="0" step="0.01">
        </td>
        <td class="px-6 py-3 border w-1/12 text-center">
            <button type="button" onclick="removeLine(this)" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Remove</button>
        </td>
    `;
    tableBody.appendChild(newRow);
}
</script>
@endsection
