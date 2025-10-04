@extends('layouts.app')

@section('content')
    <div class="w-full mt-6">
        
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

    <!-- This is where ledger HTML will be injected -->
    <div id="customerDataDiv" class="mt-6"></div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const customerDropdown = new Choices("#customerdropdown3", {
                searchEnabled: true,
                placeholderValue: "Search for a customer..."
            });

            const dropdown = document.querySelector("#customerdropdown3");

            dropdown.addEventListener("change", async (event) => {
                const customerId = event.target.value;
                console.log("Selected Customer ID:", customerId);

                try {
                    const res = await fetch(`/customers/ledger/data/${customerId}`);

                    const data = await res.json(); // expecting { html: '...' }
                    console.log("Customer Data:", data);

                    // inject the HTML into a target div
                    document.getElementById("customerDataDiv").innerHTML = data.html;

                    // re-initialize DataTable on the injected table
                    if ($.fn.DataTable.isDataTable('#ledgerTable')) {
                        $('#ledgerTable').DataTable().destroy();
                    }
                    $('#ledgerTable').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        info: true
                    });

                } catch (err) {
                    console.error("Error fetching customer data:", err);
                    document.getElementById("customerDataDiv").innerHTML =
                        '<div class="text-red-500">Failed to load ledger.</div>';
                }

            });
        });
    </script>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
@endsection
