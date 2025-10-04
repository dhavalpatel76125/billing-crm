{{-- resources/views/partials/customer_ledger_table.blade.php --}}
<div class="mt-6 bg-white p-4 rounded shadow">
    <h2 class="font-semibold mb-3">Customer Ledger</h2>

    <table id="ledgerTable" class="display stripe hover" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Reference</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Running Balance</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($entries as $e)
                <tr>
                    <td>{{ optional($e->entry_at)->format('d-m-Y H:i') }}</td>
                    <td>
                        @if($e->invoice_id)
                            {{ $e->side === 'debit' ? 'Invoice' : 'Payment' }}
                        @else
                            {{ $e->side === 'credit' ? 'Payment' : ucfirst($e->side) }}
                        @endif
                    </td>
                    <td>
                        @if($e->invoice_id)
                            {{-- If you prefer invoice_number, change controller to eager-load invoice --}}
                            {{ 'INV-' . $e->invoice_id }}
                        @else
                            {{ $e->remarks ?? '' }}
                        @endif
                    </td>
                    <td class="text-right">
                        @if($e->side === 'debit') {{ number_format($e->amount, 2, '.', '') }} @endif
                    </td>
                    <td class="text-right">
                        @if($e->side === 'credit') {{ number_format($e->amount, 2, '.', '') }} @endif
                    </td>
                    <td class="text-right">{{ $e->running_balance }}</td>
                    <td>{{ $e->remarks ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-600 py-6">No ledger entries found for this customer.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
