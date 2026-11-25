<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('contact')->latest()->paginate(10);
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $vendors = Contact::where('type', 'vendor')->orWhere('type', 'both')->get();
        $products = Product::all();
        $billNumber = 'BILL-' . date('Ymd') . '-' . rand(100, 999);
        return view('bills.create', compact('vendors', 'products', 'billNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'bill_number' => 'required|string|unique:bills',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            $bill = Bill::create([
                'contact_id' => $request->contact_id,
                'bill_number' => $request->bill_number,
                'date' => $request->date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'total' => $total,
                'notes' => $request->notes,
            ]);

            foreach ($request->items as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                BillItem::create([
                    'bill_id' => $bill->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                // Increase stock and optionally update buy_price
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock += $item['quantity'];
                    $product->buy_price = $item['price']; // Update purchase price to latest
                    $product->save();
                }
            }
        });

        return redirect()->route('bills.index')->with('success', 'Transaksi Pembelian berhasil dicatat dan stok bertambah.');
    }

    public function show(Bill $bill)
    {
        $bill->load('contact', 'items.product');
        return view('bills.show', compact('bill'));
    }

    public function destroy(Bill $bill)
    {
        DB::transaction(function () use ($bill) {
            foreach ($bill->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item->quantity);
                    $product->save();
                }
            }
            $bill->delete();
        });

        return redirect()->route('bills.index')->with('success', 'Pembelian berhasil dihapus dan stok disesuaikan.');
    }

    public function edit(Bill $bill)
    {
        $bill->load('items.product');
        $vendors = Contact::where('type', 'vendor')->orWhere('type', 'both')->get();
        $products = Product::all();
        return view('bills.edit', compact('bill', 'vendors', 'products'));
    }

    public function update(Request $request, Bill $bill)
    {
        $data = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'bill_number' => 'required|string|unique:bills,bill_number,' . $bill->id,
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $bill) {
            foreach ($bill->items as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product) {
                    $product->stock = max(0, $product->stock - $oldItem->quantity);
                    $product->save();
                }
            }
            $bill->items()->delete();
            $total = collect($request->items)->sum(fn ($item) => $item['quantity'] * $item['price']);
            $bill->update([
                'contact_id' => $request->contact_id,
                'bill_number' => $request->bill_number,
                'date' => $request->date,
                'due_date' => $request->due_date,
                'status' => $request->status,
                'total' => $total,
                'notes' => $request->notes,
            ]);
            foreach ($request->items as $item) {
                BillItem::create([
                    'bill_id' => $bill->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->stock += $item['quantity'];
                    $product->buy_price = $item['price'];
                    $product->save();
                }
            }
        });
        return redirect()->route('bills.index')->with('success', 'Pembelian berhasil diperbarui.');
    }

    public function pdf(Bill $bill)
    {
        $bill->load('contact', 'items.product');
        return Pdf::loadView('bills.pdf', compact('bill'))
            ->setPaper([0, 0, 595.28, 935.43], 'portrait')
            ->download('Pembelian-' . $bill->bill_number . '.pdf');
    }

}
