<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $sale->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; padding: 40px; }
        .header { border-bottom: 3px solid #0d9488; padding-bottom: 20px; margin-bottom: 30px; }
        .hospital-name { font-size: 28px; font-weight: bold; color: #0d9488; }
        .hospital-address { color: #666; font-size: 14px; margin-top: 5px; }
        .invoice-title { text-align: center; font-size: 22px; font-weight: bold; color: #0d9488; margin: 25px 0; text-transform: uppercase; letter-spacing: 2px; }
        .invoice-number { text-align: center; font-size: 16px; color: #666; margin-bottom: 25px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-box { background: #f8fafc; padding: 15px; border-radius: 8px; border-left: 4px solid #0d9488; }
        .info-label { font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        .info-value { font-size: 16px; font-weight: 600; color: #1e293b; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #0d9488; color: white; padding: 12px; text-align: left; font-size: 14px; }
        td { padding: 12px; border-bottom: 1px solid #e2e8f0; font-size: 14px; }
        tr:nth-child(even) { background: #f8fafc; }
        .total-section { margin-top: 30px; text-align: right; }
        .total-label { font-size: 18px; color: #666; }
        .total-amount { font-size: 36px; font-weight: bold; color: #0d9488; margin-top: 10px; }
        .pharmacist-info { margin-top: 30px; background: #f0fdfa; padding: 15px; border-radius: 8px; }
        .footer { margin-top: 50px; padding-top: 20px; border-top: 1px solid #e2e8f0; text-align: center; color: #666; font-size: 14px; }
        .thank-you { font-size: 18px; color: #0d9488; font-weight: 600; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="hospital-name">MediFlow Hospital</div>
            <div class="hospital-address">123 Healthcare Avenue, Medical District, MD 12345 | Phone: (555) 123-4567</div>
        </div>

        <div class="invoice-title">Invoice</div>
        <div class="invoice-number">Invoice #INV-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</div>

        <div class="info-grid">
            <div class="info-box">
                <div class="info-label">Patient Name</div>
                <div class="info-value">{{ $sale->patient->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-box">
                <div class="info-label">Sale Date</div>
                <div class="info-value">{{ $sale->sale_date->format('M d, Y') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Medicine</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->saleItems as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->medicine->medicine_name ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-label">Total Amount</div>
            <div class="total-amount">${{ number_format($sale->total_amount, 2) }}</div>
        </div>

        <div class="pharmacist-info">
            <div class="info-label">Processed By</div>
            <div class="info-value">{{ $sale->pharmacist->name ?? 'N/A' }}</div>
        </div>

        <div class="footer">
            <div>For any queries, please contact the pharmacy department.</div>
            <div class="thank-you">Thank you for choosing MediFlow Hospital!</div>
        </div>
    </div>
</body>
</html>
