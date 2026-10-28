<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $sale->invoice_number ?? 'INV-SL-' . $sale->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 300px;
            margin: 0 auto;
            padding: 15px;
            color: #000;
            background: #fff;
        }
        .text-center { text-align: center; }
        .flex { display: flex; justify-content: space-between; }
        hr { border: none; border-top: 1px dashed #000; margin: 10px 0; }
        .mb-2 { margin-bottom: 8px; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center mb-2">
        <h2 style="margin: 0;">DIOR BOUTIQUE</h2>
        <p style="font-size: 12px; margin: 2px 0;">Manajemen Butik Eksklusif</p>
    </div>
    <hr>
    <div style="font-size: 12px;">
        <p style="margin: 4px 0;">No. Faktur : {{ $sale->invoice_number ?? 'INV-SL-' . $sale->id }}</p>
        <p style="margin: 4px 0;">Tanggal   : {{ $sale->created_at->format('Y-m-d H:i') }}</p>
        <p style="margin: 4px 0;">Pelanggan : {{ $sale->customer_name ?? '-' }}</p>
    </div>
    <hr>
    <div style="font-size: 12px;">
        <p style="margin: 4px 0;"><strong>{{ $sale->product->name ?? 'Produk' }}</strong></p>
        <div class="flex">
            <span>{{ $sale->quantity ?? 1 }}x @ Rp {{ number_format(($sale->total ?? $sale->total_amount) / ($sale->quantity ?? 1), 0, ',', '.') }}</span>
            <span>Rp {{ number_format($sale->total ?? $sale->total_amount ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>
    <hr>
    <div class="flex" style="font-size: 14px; font-weight: bold;">
        <span>TOTAL:</span>
        <span>Rp {{ number_format($sale->total ?? $sale->total_amount ?? 0, 0, ',', '.') }}</span>
    </div>
    <hr>
    <div class="text-center" style="font-size: 11px; margin-top: 15px;">
        <p style="margin: 2px 0;">Terima Kasih atas Kunjungan Anda</p>
        <p style="margin: 2px 0;">Barang yang sudah dibeli tidak dapat ditukar.</p>
    </div>
</body>
</html>