@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl text-black pb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Invoice Card -->
        <a href="{{ route('invoices.index') }}">
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
        <a href="{{ route('products.index') }}">
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
        <a href="{{ route('customers.index') }}">
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
        <!-- Receipt Card -->
        <div onclick="showcustomer()">
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-pink-500 text-white rounded-full p-3">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-bold text-gray-700">Receipt</h2>
                        <p class="text-sm text-gray-500">Manage your receipts</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <span class="text-pink-500 text-sm font-semibold hover:underline">View Details</span>
                </div>
            </div>
        </div>
        <!-- Ladger -->
        <a href="{{ route('ladger.index') }}">
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center">
                    <div class="bg-yellow-500 text-white rounded-full p-3">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-lg font-bold text-gray-700">Ladger</h2>
                        <p class="text-sm text-gray-500">See your customer ladger</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <span class="text-yellow-500 text-sm font-semibold hover:underline">View Details</span>
                </div>
            </div>
        </a>
    </div>

    <div class="mt-8" id="showcustomer" hidden>
        <label for="customer" class="block text-gray-800 font-semibold mb-2">Customer</label>
        <select id="customerdropdown2" name="customer"
            class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500" required>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">Name: {{ $customer->name }} | Phone:
                    {{ $customer->phone }}</option>
            @endforeach
        </select>
    </div><br>
    <!-- Customer Balance Table (place this where you want rows to appear) -->
    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Total Credit</th>
                <th class="border px-4 py-2">Total Debit</th>
                <th class="border px-4 py-2">Balance</th>
                <th class="border px-4 py-2">Do Transaction</th>
                <th class="border px-4 py-2">Save</th>
                {{-- <th class="border px-4 py-2">Remarks</th>
                <th class="border px-4 py-2">Action</th> --}}
            </tr>
        </thead>
        <tbody id="customerDataDiv">
            <!-- AJAX will inject <tr> here -->
        </tbody>
    </table>
    @include('model')
@endsection

<script>
    function showcustomer() {
        document.getElementById("showcustomer").removeAttribute("hidden");
    }

    document.addEventListener("DOMContentLoaded", () => {
        const customerDropdown = new Choices("#customerdropdown2", {
            searchEnabled: true,
            placeholderValue: "Search for a customer..."
        });

        const dropdown = document.querySelector("#customerdropdown2");

        dropdown.addEventListener("change", async (event) => {
            const customerId = event.target.value;
            console.log("Selected Customer ID:", customerId);

            try {
                const res = await fetch(`/customers/data/${customerId}`);

                const data = await res.json(); // controller returns JSON with HTML inside
                console.log("Customer Data:", data);
                document.getElementById("customerDataDiv").innerHTML = data;

            } catch (err) {
                console.error("Error fetching customer data:", err);
            }
        });
    });


    // submit transaction
    function submitTransaction(balanceId) {
        // read amount from the uniquely-named input
        const amountInput = document.getElementById('transactionAmount-' + balanceId);
        console.log('Amount Input:', amountInput);
        if (!amountInput) {
            alert('Amount input not found.');
            return;
        }

        const amount = parseFloat(amountInput.value);
        if (isNaN(amount) || amount <= 0) {
            alert('Please enter a valid transaction amount.');
            return;
        }

        // optional: if you have a remarks field per row, adapt its id similarly.
        // const remarks = document.getElementById('transactionRemarks-' + balanceId)?.value || '';
        const remarks = ''; // or retrieve from DOM if you added a remarks input

        // get CSRF token from meta tag (works in Blade or plain PHP layouts)
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        // create form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/balance-sheet/${balanceId}/update-credit`; // matches your route
        form.style.display = 'none';

        // _token
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);

        // _method spoofing to PUT
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        // credit_amount (controller expects this name)
        const creditInput = document.createElement('input');
        creditInput.type = 'hidden';
        creditInput.name = 'credit_amount';
        creditInput.value = amount;
        form.appendChild(creditInput);

        // optional remarks
        const remarksInput = document.createElement('input');
        remarksInput.type = 'hidden';
        remarksInput.name = 'remarks';
        remarksInput.value = remarks;
        form.appendChild(remarksInput);

        document.body.appendChild(form);
        form.submit();
    }
</script>
