<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Faktur {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.4; }
        .header { width: 100%; border-bottom: 2px solid #10b981; padding-bottom: 10px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .title { font-size: 22px; font-weight: bold; color: #10b981; }
        .invoice-info { text-align: right; }
        .section-title { font-size: 11px; font-weight: bold; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.items th, table.items td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.items th { background-color: #f3f4f6; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-section { margin-top: 20px; float: right; width: 250px; }
        .total-section table { width: 100%; }
        .total-section td { padding: 5px; }
        .grand-total { font-size: 14px; font-weight: bold; color: #10b981; border-top: 2px solid #10b981; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td>
                    <div class="title">FAKTUR PENJUALAN</div>
                    <div style="font-size: 14px; font-weight: bold;">{{ \App\Models\CompanyProfile::current()->name }}</div>
                    <div>{{ \App\Models\CompanyProfile::current()->address }}</div>
                    <div>Telp: {{ \App\Models\CompanyProfile::current()->phone }} | Email: {{ \App\Models\CompanyProfile::current()->email }}</div>
                    <div>NPWP: {{ \App\Models\CompanyProfile::current()->tax_number }}</div>
                </td>
                <td class="invoice-info">
                    <div><strong>No: {{ $invoice->invoice_number }}</strong></div>
                    <div>Tanggal: {{ $invoice->date }}</div>
                    <div>Jatuh Tempo: {{ $invoice->due_date }}</div>
                    <div>Status: <strong>{{ strtoupper($invoice->status) }}</strong></div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 20px;">
        <div class="section-title">Kepada Pelanggan:</div>
        <div style="font-size: 14px; font-weight: bold;">{{ $invoice->contact->name ?? '-' }}</div>
        <div>{{ $invoice->contact->address ?? '' }}</div>
        <div>Telp: {{ $invoice->contact->phone ?? '-' }}</div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table>
            <tr><td>Ongkos Kirim:</td><td class="text-right">Rp {{ number_format($invoice->shipping_cost ?? 0, 0, ',', '.') }}</td></tr>
            <tr class="grand-total">
                <td>Total Tagihan:</td>
                <td class="text-right">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if($invoice->notes)
    <div style="margin-top: 40px; clear: both;">
        <div class="section-title">Catatan:</div>
        <div>{{ $invoice->notes }}</div>
    </div>
    @endif
</body>
</html>
