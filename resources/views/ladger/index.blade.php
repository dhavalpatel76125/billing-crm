@extends('layouts.app')

@section('content')
    <div class="w-full mt-6">
        <div class="w-1/4 mb-4">
            <div
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
                Choose Customer
            </div>
        </div>
        <div class="bg-white">
            <div class="mt-8">
                <label for="customer" class="block text-gray-800 font-semibold mb-2">Customer</label>
                <select id="customerdropdown3" name="customer"
                    class="w-full border border-gray-400 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">Name: {{ $customer->name }} | Phone:
                            {{ $customer->phone }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <script>
document.addEventListener("DOMContentLoaded", () => {
        const customerDropdown = new Choices("#customerdropdown3", {
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
    </script>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

@endsection
