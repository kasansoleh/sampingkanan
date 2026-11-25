<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('contact')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Contact::where('type', 'customer')->orWhere('type', 'both')->get();
        $products = Product::all();
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(100, 999);
        return view('invoices.create', compact('customers', 'products', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'invoice_number' => 'required|string|unique:invoices',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            $invoice = Invoice::create([
                'contact_id' => $request->contact_id,
                'invoice_number' => $request->invoice_number,
                'date' => $request->date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'total' => $total + (float) ($request->shipping_cost ?? 0),
                'shipping_cost' => $request->shipping_cost ?? 0,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                // Reduce stock
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item['quantity']);
                    $product->save();
                }
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Faktur Penjualan berhasil dibuat.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('contact', 'items.product');
        return view('invoices.show', compact('invoice'));
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load('contact', 'items.product');
        
        // F4 dimensions in points: 210mm x 330mm -> 595.28 pt x 935.43 pt
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
                 ->setPaper([0, 0, 595.28, 935.43], 'portrait');

        return $pdf->download('Faktur-' . $invoice->invoice_number . '.pdf');
    }

    public function destroy(Invoice $invoice)
    {
        DB::transaction(function () use ($invoice) {
            foreach ($invoice->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock += $item->quantity;
                    $product->save();
                }
            }
            $invoice->delete();
        });

        return redirect()->route('invoices.index')->with('success', 'Faktur berhasil dihapus.');
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('contact', 'items.product');
        $customers = Contact::where('type', 'customer')->orWhere('type', 'both')->get();
        $products = Product::all();
        return view('invoices.edit', compact('invoice', 'customers', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id,
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $invoice) {
            // Restore previous stock
            foreach ($invoice->items as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->stock += $oldItem->quantity;
                    $product->save();
                }
            }

            // Delete old items
            $invoice->items()->delete();

            // Calculate new total
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            // Update invoice
            $invoice->update([
                'contact_id' => $request->contact_id,
                'invoice_number' => $request->invoice_number,
                'date' => $request->date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'total' => $total + (float) ($request->shipping_cost ?? 0),
                'shipping_cost' => $request->shipping_cost ?? 0,
                'notes' => $request->notes,
            ]);

            // Create new items and reduce stock
            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item['quantity']);
                    $product->save();
                }
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Faktur Penjualan berhasil diperbarui.');
    }

}
