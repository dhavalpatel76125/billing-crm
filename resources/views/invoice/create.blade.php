@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 max-w-7xl">
        <h1 class="text-3xl font-bold text-center text-purple-700 mb-8">New Invoice</h1>
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
            <form action="/invoices/store" method="POST">
                @csrf
                <!-- Customer and Invoice Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="customer" class="block text-gray-800 font-semibold mb-2">Customer</label>
                        <select id="customerdropdown" name="customer"
                            class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">Name: {{ $customer->name }} | Phone:
                                    {{ $customer->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block text-gray-800 font-semibold mb-2">Date</label>
                        <input type="date" id="date" name="date"
                            class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required disabled>
                    </div>
                    <div>
                        <label for="reference" class="block text-gray-800 font-semibold mb-2">Reference (Optional)</label>
                        <input type="text" id="reference" name="reference"
                            class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="vehicle_number" class="block text-gray-800 font-semibold mb-2">Vehicle Number
                            (Optional)</label>
                        <input type="text" id="vehicle_number" name="vehicle_number"
                            class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Invoice Table -->
                <div class="overflow-x-auto mb-8">
                    <table class="w-full text-left border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border">Item</th>
                                {{-- <th class="px-6 py-3 border">Description</th> --}}
                                <th class="px-6 py-3 border">Qty</th>
                                <th class="px-6 py-3 border">Unit Price</th>
                                <th class="px-6 py-3 border text-right">Total</th>
                                <th class="px-6 py-3 border text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-table-body">
                            <!-- Dynamic Rows -->
                        </tbody>
                    </table>
                </div>

                <button type="button" onclick="addNewLine()"
                    class="mt-4 bg-green-500 text-white py-3 px-8 rounded shadow-md hover:bg-green-600">Add New
                    Line</button>

                <!-- Totals -->
                <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center font-medium text-lg">
                        <span>Product Total:</span>
                        <span id="product-total">₹0.00</span>
                        <input type="number" id="product-total-for-hidden" name="product-total-for-hidden"
                            class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-blue-600"
                            placeholder="Product Total" min="0" step="0.01" hidden>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <label for="freight" class="text-gray-800 font-medium">Freight:</label>
                        <input type="number" id="freight" name="freight"
                            class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-blue-600"
                            placeholder="Freight" min="0" onchange="updateTotals()">
                    </div>
                    <div class="flex justify-between items-center font-medium text-lg">
                        <span> Total of Product & Freight:</span>
                        <input type="number" id="total-of-product-and-freight-for-hidden"
                            name="total-of-product-and-freight-for-hidden"
                            class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-blue-600"
                            placeholder="Total of Product & Freight" min="0" step="0.01" hidden>
                        <span id="total-of-product-and-freight">₹0.00</span>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <label for="credit" class="text-gray-800 font-medium">Credit (Received):</label>
                        <input type="number" id="credit" name="credit"
                            class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-red-700"
                            placeholder="Credit" step="0.01" onchange="updateTotals()">
                    </div>
                    <div class="flex justify-between items-center font-medium text-lg">
                        <span>Grand Total (After Credit):</span>
                        <span id="grand-total">₹0.00</span>
                        <input type="number" id="grand-total-for-hidden" name="grand-total-for-hidden"
                            class="w-32 px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-blue-600"
                            placeholder="Grand Total"  step="0.01" hidden>
                    </div>
                </div>

                <button type="submit"
                    class="mt-8 w-full bg-blue-500 text-white py-3 rounded shadow-md hover:bg-blue-600">Save</button>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerDropdown = new Choices("#customerdropdown", {
            searchEnabled: true,
            placeholderValue: "Search for a customer..."
        });
    });

    function addNewLine() {
        const tableBody = document.getElementById('invoice-table-body');
        const row = document.createElement('tr');

        row.innerHTML = `
        <td class="px-6 py-3 border w-2/5">
            <select name="product_id[]" class="productdropdown w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>Select a product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->description }}</option>
                @endforeach
            </select>
        </td>
        <td class="px-6 py-3 border w-1/5" hidden>
            <textarea name="description[]" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Description"></textarea>
        </td>
        <td class="px-6 py-3 border w-1/6">
            <input type="number" name="quantity[]" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="0" onchange="updateTotals()">
        </td>
<td class="px-6 py-3 border w-1/6">
    <input type="number" name="unit_price[]" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="0" step="0.01" onchange="updateTotals()">
</td>

        <td class="px-6 py-3 border w-1/6 text-right">
            <span class="item-total">₹0.00</span>
            <input type="number" name="total[]" class="w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="0" step="0.01" hidden>
        </td>
        <td class="px-6 py-3 border w-1/12 text-center">
            <button type="button" onclick="removeLine(this)" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Remove</button>
        </td>
    `;

        tableBody.appendChild(row);
    }

    function removeLine(button) {
        const row = button.closest('tr');
        row.remove();
        updateTotals();
    }

    function updateTotals() {
        const tableBody = document.getElementById('invoice-table-body');
        const rows = tableBody.querySelectorAll('tr');
        let productTotal = 0;

        // Calculate product total from all rows
        rows.forEach(row => {
            const unitPrice = Math.max(0, parseFloat(row.querySelector('input[name="unit_price[]"]').value) ||
                0);
            const quantity = Math.max(0, parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0);
            const total = unitPrice * quantity;

            row.querySelector('input[name="total[]"]').value = total;
            row.querySelector('.item-total').textContent = `₹${total.toFixed(2)}`;
            productTotal += total;
        });

        // Get freight and credit values
        const freight = Math.max(0, parseFloat(document.getElementById('freight').value) || 0);
        const credit = Math.max(0, parseFloat(document.getElementById('credit').value) || 0);

        // Calculate totals
        const totalOfProductAndFreight = productTotal + freight;
        const grandTotal = totalOfProductAndFreight - credit;

        // Update product total
        document.getElementById('product-total').textContent = `₹${productTotal.toFixed(2)}`;
        document.getElementById('product-total-for-hidden').value = productTotal;

        // Update total of product and freight
        document.getElementById('total-of-product-and-freight').textContent = `₹${totalOfProductAndFreight.toFixed(2)}`;
        document.getElementById('total-of-product-and-freight-for-hidden').value = totalOfProductAndFreight;

        // Update grand total
        document.getElementById('grand-total').textContent = `₹${grandTotal.toFixed(2)}`;
        document.getElementById('grand-total-for-hidden').value = grandTotal;
    }
</script>
