<?php

namespace App\Http\Controllers;

use App\Models\BalanceSheet;
use App\Models\Customer;


class DashboardController extends Controller
{
    // Index method
    public function index()
    {
        $customers = Customer::all();

        return view('dashboard', compact('customers'));
    }

    // Method to get customer data by ID
    public function getCustomerData($id)
    {
        // Fetch all balance sheets with related customer data (exclude zero balances)
        $balance = BalanceSheet::with('customer')
            ->where('customer_id', $id)
            ->first();

        if (!$balance) {
            return response()->json('<tr><td colspan="8" class="text-center py-2">No balance found</td></tr>');
        }

        // Prepare safe values
        $customerName   = e($balance->customer->name);
        $customerPhone  = e($balance->customer->phone);
        $totalCredit    = number_format($balance->total_credit, 2);
        $totalDebit     = number_format($balance->total_debit, 2);
        $balanceAmount  = number_format($balance->balance, 2);
        $remarks        = e($balance->remarks ?? '');
        $lastCreditAt   = $balance->last_credit_updated_at ? $balance->last_credit_updated_at->format('d-m-Y H:i') : '';
        $lastCreditAmt  = $balance->last_credit_amount ? '₹' . number_format($balance->last_credit_amount, 2) : '';

        // Build HTML row
      $html = "
<tr>
    <td class='border px-4 py-2'>{$customerName}</td>
    <td class='border px-4 py-2'>{$customerPhone}</td>
    <td class='border px-4 py-2'>₹{$totalCredit}</td>
    <td class='border px-4 py-2'>₹{$totalDebit}</td>
    <td class='border px-4 py-2'>₹{$balanceAmount}</td>

    <td>
        <input 
            type='number'  
            class='w-full px-4 py-3 border border-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500' 
            placeholder='0' 
            min='0' 
            id='transactionAmount-{$balance->id}' />
    </td>

    <td>
        <button 
            type='button' 
            class='w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200' 
            onclick='submitTransaction({$balance->id})'>
            Submit
        </button>
    </td>
</tr>";


        return response()->json($html);
    }
}
