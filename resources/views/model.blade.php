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
                <input type="number" min="0" name="credit_amount" 
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