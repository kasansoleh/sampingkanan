<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Bill;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = Contact::where('type', 'customer')->orWhere('type', 'both')->count();
        $totalVendors = Contact::where('type', 'vendor')->orWhere('type', 'both')->count();
        $totalProducts = Product::count();
        $totalInvoices = Invoice::count();
        $revenue = Invoice::where('status', 'paid')->sum('total');
        $pendingRevenue = Invoice::where('status', 'sent')->sum('total');
        $totalExpenses = Bill::where('status', 'paid')->sum('total');

        $recentInvoices = Invoice::with('contact')->latest()->take(5)->get();
        $recentBills = Bill::with('contact')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalCustomers', 'totalVendors', 'totalProducts', 'totalInvoices',
            'revenue', 'pendingRevenue', 'totalExpenses', 'recentInvoices', 'recentBills'
        ));
    }
}
