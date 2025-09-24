<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\BalanceSheet;
use App\Models\LedgerEntry;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Index method
    public function index()
    {
        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    // Create method
    public function create()
    {
        return view('customers.create');
    }

    // Store method
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|unique:customers,name|max:255',
            'phone' => 'required|unique:customers,phone|digits_between:10,15',
        ]);

        // Save customer
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer created successfully!');
    }

    // Edit method
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    // Update method
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'name' => 'required|unique:customers,name,' . $id . '|max:255',
            'phone' => 'required|unique:customers,phone,' . $id . '|digits_between:10,15',
        ]);

        // Update customer
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    // Delete method
    public function delete(Request $request)
    {
        $customer = Customer::findOrFail($request->id);
        $customer->delete();

        $customers = Customer::all();

        return view('customers.index', compact('customers'));
    }

    public function transactions($id)
    {
        $customer = Customer::findOrFail($id);
        $transactions = Invoice::where('customer_id', $id)
            ->select('id', 'invoice_number', 'date', 'subtotal', 'freight', 'credit', 'total', 'grand_total')
            ->orderBy('date', 'desc')
            ->get();

        // Calculate totals
        $totalCredit = $transactions->sum('credit');
        $totalDebit = $transactions->sum('total');
        $balance = $totalDebit - $totalCredit;

        return view('customers.customer_wise_transaction', compact('customer', 'transactions', 'totalCredit', 'totalDebit', 'balance'));
    }

    public function showBalanceSheet()
    {
        // Fetch all balance sheets with related customer data plus and minus allowed but 0 not allowed 
        $balanceSheets = BalanceSheet::with('customer')->get();

        // Pass the data to the view
        return view('customers.balance_sheet', compact('balanceSheets'));
    }


    //getLedgerData
    public function getLedgerData($customerId)
    {
        
        $ledgerentries = LedgerEntry::where('customer_id', $customerId)
            ->orderBy('entry_at', 'desc')
            ->get();
        return response()->json($ledgerentries);
    }
}
