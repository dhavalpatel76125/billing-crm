<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\BalanceSheet;
use App\Models\InvoiceNumber;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // index method

    public function index()
    {
        $invoices = Invoice::with([
            'invoiceItems.product' => function ($query) {
                $query->select('id', 'name');
            },
            'customer' => function ($query) {
                $query->select('id', 'name', 'phone');
            }
        ])
            ->select('id', 'customer_id', 'invoice_number', 'date', 'subtotal', 'freight', 'credit', 'total', 'reference', 'vehicle_number')
            ->get();
        // dd($invoices);
        return view('invoice.index', compact('invoices'));
    }


    //create method

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('invoice.create', compact('customers', 'products'));
    }


    //store
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'customer' => 'required|exists:customers,id',
            'date' => 'required|date',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'unit_price' => 'required|array',
            'unit_price.*' => 'numeric',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric',
            'credit' => 'nullable|numeric|min:0',
            'freight' => 'nullable|numeric|min:0',
            'product-total-for-hidden' => 'required|numeric|min:0',
        ]);

        // Fetch the last used invoice number and increment it
        $invoiceNumberRecord = InvoiceNumber::first();
        if (!$invoiceNumberRecord) {
            $invoiceNumberRecord = InvoiceNumber::create(['last_number' => 1]);
        } else {
            $invoiceNumberRecord->increment('last_number');
        }

        $invoiceNumber = 'INV-' . $invoiceNumberRecord->last_number;

        // Calculate totals
        $subtotal = $request->input('product-total-for-hidden');
        $freight = $request->input('freight') ?? 0;
        $totalDebit = $subtotal + $freight;
        $credit = $request->input('credit') ?? 0;

        // Create the invoice
        $invoice = Invoice::create([
            'customer_id' => $request->customer,
            'invoice_number' => $invoiceNumber,
            'date' => $request->date,
            'subtotal' => $subtotal,
            'freight' => $freight,
            'credit' => $credit,
            'total' => $totalDebit,
        ]);

        // Insert the invoice items
        foreach ($request->product_id as $index => $product_id) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $product_id,
                'description' => $request->description[$index],
                'unit_price' => $request->unit_price[$index],
                'quantity' => $request->quantity[$index],
                'total' => $request->unit_price[$index] * $request->quantity[$index],
            ]);
        }

        // Update balance sheet
        $this->updateBalanceSheet($request->customer, $totalDebit, $credit);

        // Return a success response or redirect
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
    }


    //edit method

    public function edit($id)
    {

        $invoice = Invoice::with([
            'invoiceItems.product' => function ($query) {
                $query->select('id', 'name');
            },
            'customer' => function ($query) {
                $query->select('id', 'name', 'phone');
            }
        ])
            ->where('id', $id)
            ->select('id', 'customer_id', 'invoice_number', 'date', 'subtotal', 'freight', 'credit', 'total', 'reference', 'vehicle_number')
            ->firstOrFail();
        $customers = Customer::all();
        $products = Product::all();
        // dd($invoice);
        return view('invoice.edit', compact('invoice', 'customers', 'products'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'customer' => 'required|exists:customers,id',
            'date' => 'required|date',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'unit_price' => 'required|array',
            'unit_price.*' => 'numeric',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric',
            'credit' => 'nullable|numeric',
            'freight' => 'nullable|numeric',
        ]);

        // Find the invoice by ID
        $invoice = Invoice::findOrFail($id);

        // Use the total from the request instead of calculating it
        $subtotal = $request->input('product-total-for-hidden');
        $freight = $request->input('freight') ?? 0;
        $credit = $request->input('credit') ?? 0;
        $total = $request->input('grand-total-for-hidden');

        // Update the invoice
        $invoice->update([
            'customer_id' => $request->customer,
            'date' => $request->date,
            'subtotal' => $subtotal,
            'reference' => $request->reference,
            'vehicle_number' => $request->vehicle_number,
            'freight' => $freight,
            'credit' => $credit,
            'total' => $total,
        ]);

        // Collect existing invoice item IDs
        $existingItemIds = $invoice->invoiceItems()->pluck('id')->toArray();
        $updatedItemIds = [];

        // Update or create invoice items
        foreach ($request->product_id as $index => $product_id) {
            $itemId = $request->invoice_item_id[$index] ?? null;
            $itemData = [
                'product_id' => $product_id,
                'description' => $request->description[$index],
                'unit_price' => $request->unit_price[$index],
                'quantity' => $request->quantity[$index],
                'total' => $request->unit_price[$index] * $request->quantity[$index],
            ];

            if ($itemId && in_array($itemId, $existingItemIds)) {
                // Update existing item
                InvoiceItem::where('id', $itemId)->update($itemData);
                $updatedItemIds[] = $itemId;
            } else {
                // Create new item
                $newItem = InvoiceItem::create(array_merge($itemData, ['invoice_id' => $invoice->id]));
                $updatedItemIds[] = $newItem->id;
            }
        }

        // Delete removed invoice items
        $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
        if (!empty($itemsToDelete)) {
            InvoiceItem::whereIn('id', $itemsToDelete)->delete();
        }

        // Update balance sheet
        $this->updateBalanceSheet($request->customer, $request->input('grand-total-for-hidden'), $request->input('credit'));

        // Return a success response or redirect
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully');
    }

    //show method
    public function show($id)
    {
        $invoice = Invoice::with([
            'invoiceItems.product' => function ($query) {
                $query->select('id', 'name');
            },
            'customer' => function ($query) {
                $query->select('id', 'name', 'phone');
            }
        ])
            ->where('id', $id)
            ->select('id', 'customer_id', 'invoice_number', 'date', 'subtotal', 'freight', 'credit', 'total', 'reference', 'vehicle_number')
            ->firstOrFail();

        return view('invoice.show', compact('invoice'));
    }

    //destroy method
    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully');
    }

    private function updateBalanceSheet($customerId, $totalDebit, $credit)
    {
        $balanceSheet = BalanceSheet::firstOrNew(['customer_id' => $customerId]);
        $balanceSheet->total_credit += $credit;
        $balanceSheet->total_debit += $totalDebit;
        $balanceSheet->balance = $balanceSheet->total_debit - $balanceSheet->total_credit;
        $balanceSheet->save();
    }
}
