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
                    <th class="border px-4 py-2">Last Credit Update</th>
                    <th class="border px-4 py-2">Remarks</th>
                    <th class="border px-4 py-2">Actions</th>
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
                    <td class="border px-4 py-2">
                        @if($balance->last_credit_updated_at)
                            {{ $balance->last_credit_updated_at->format('d-m-Y H:i') }}
                            <br>
                            <small>₹{{ number_format($balance->last_credit_amount, 2) }}</small>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $balance->remarks }}</td>
                    <td class="border px-4 py-2">
                        <button onclick="openCreditModal({{ $balance->id }}, '{{ $balance->customer->name }}')" 
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                            Edit Credit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Credit Edit Modal -->
<div id="creditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
    <div class="modal-container bg-white w-96 mx-auto mt-20 p-6 rounded-lg">
        <h2 class="text-xl font-bold mb-4">Edit Credit for <span id="customerName"></span></h2>
        <form id="creditForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Credit Amount
                </label>
                <input type="number" step="0.01" name="credit_amount" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Remarks
                </label>
                <textarea name="remarks" 
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                          required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeCreditModal()" 
                        class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Update Credit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreditModal(balanceId, customerName) {
    document.getElementById('creditModal').classList.remove('hidden');
    document.getElementById('customerName').textContent = customerName;
    document.getElementById('creditForm').action = `/balance-sheet/${balanceId}/update-credit`;
}

function closeCreditModal() {
    document.getElementById('creditModal').classList.add('hidden');
}

// Confirmation before submit
document.getElementById('creditForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm('Are you sure you want to update the credit amount?')) {
        this.submit();
    }
});
</script>

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
