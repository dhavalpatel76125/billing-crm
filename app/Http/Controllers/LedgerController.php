<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\BalanceSheet;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    // Index method
    public function index()
    {
        $customers = Customer::all();

        return view('ledger.index', compact('customers'));
    }

}
