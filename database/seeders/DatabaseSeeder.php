<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Company Profile
        CompanyProfile::updateOrCreate(['id' => 1], [
            'name' => 'SAMPING KANAN OFFICIAL',
            'email' => 'info@sampingkanan.com',
            'phone' => '021-888999',
            'address' => 'Jl. Sudirman No. 10, Jakarta Selatan',
            'tax_number' => '01.999.888.7-501.000'
        ]);

        // Seed Users
        User::updateOrCreate(['email' => 'admin@sampingkanan.com'], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::updateOrCreate(['email' => 'kasir@sampingkanan.com'], [
            'name' => 'Kasir Toko',
            'password' => Hash::make('password'),
            'role' => 'cashier'
        ]);

        // Seed Contacts
        $cust1 = Contact::create([
            'name' => 'PT Toko Makmur Jaya',
            'type' => 'customer',
            'email' => 'makmur@tokomakmur.co.id',
            'phone' => '081234567890',
            'address' => 'Jl. Sudirman No. 12, Jakarta Pusat'
        ]);

        $vendor1 = Contact::create([
            'name' => 'PT Suplier Elektronik Indonesia',
            'type' => 'vendor',
            'email' => 'sales@suplierelectronik.com',
            'phone' => '0215556789',
            'address' => 'Kawasan Industri Cikarang Blok C'
        ]);

        // Seed Products
        $prod1 = Product::create([
            'name' => 'Laptop ASUS ROG Strix G15',
            'sku' => 'PRD-ASUS-01',
            'category' => 'Elektronik',
            'buy_price' => 15000000,
            'sell_price' => 18500000,
            'stock' => 12,
            'unit' => 'unit'
        ]);

        $prod2 = Product::create([
            'name' => 'Monitor LG UltraWide 29 inch',
            'sku' => 'PRD-LG-02',
            'category' => 'Elektronik',
            'buy_price' => 3000000,
            'sell_price' => 4100000,
            'stock' => 25,
            'unit' => 'unit'
        ]);

        // Seed Invoice
        $invoice = Invoice::create([
            'contact_id' => $cust1->id,
            'invoice_number' => 'INV-20261027-001',
            'date' => now()->subDays(5),
            'due_date' => now()->addDays(25),
            'status' => 'paid',
            'total' => 18500000,
            'notes' => 'Terima kasih atas pesanan Anda.'
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product_id' => $prod1->id,
            'quantity' => 1,
            'price' => 18500000,
            'subtotal' => 18500000
        ]);
    }
}
