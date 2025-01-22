<?php

namespace App\Http\Controllers;

use App\Models\BalanceSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BalanceSheetController extends Controller
{
    public function updateCredit(Request $request, $id)
    {
        // Find the BalanceSheet record by ID
        $balanceSheet = BalanceSheet::findOrFail($id);

        // Get the new credit amount from the request
        $newCreditAmount = $request->credit_amount;

        // Update the total credit by adding the new amount
        $balanceSheet->total_credit += $newCreditAmount;

        // Recalculate the balance: total_credit - total_debit
        $balanceSheet->balance = $balanceSheet->total_credit - $balanceSheet->total_debit;

        // Update the last credit amount and timestamp
        $balanceSheet->last_credit_amount = $newCreditAmount;
        $balanceSheet->last_credit_updated_at = now();

        // Update the remarks field (optional)
        if (!empty($request->remarks)) {
            $balanceSheet->remarks = $request->remarks;
        }

        // Save the updated record
        $balanceSheet->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Credit updated successfully!');
    }
}
