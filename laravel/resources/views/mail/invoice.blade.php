<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - TastyByte</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h2 { color: #16a34a; margin: 0; font-size: 24px; }
        .header img { max-width: 150px; margin-bottom: 10px; }
        .details-table, .order-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .details-table td, .order-table th, .order-table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .order-table th { background-color: #f8f8f8; }
        .order-table tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { text-align: center; color: #777; font-size: 12px; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; }
        .btn { display: inline-block; padding: 12px 25px; background: #16a34a; color: #FFFFFF; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; transition: background 0.3s ease; }
        .btn:hover { background: #128c3d; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="http://tastybyte.my/images/Logo.png" alt="TastyByte Logo">
        <h2>TastyByte Invoice</h2>
        <p>Thank you for your purchase! 🍽️</p>
    </div>

    <table class="details-table">
        <tr><td><strong>Invoice No</strong></td><td>#{{ $payment->paymentID }}</td></tr>
        <tr><td><strong>Order ID</strong></td><td>{{ $payment->orders->orderID }}</td></tr>
        <tr><td><strong>Total</strong></td><td><strong>RM{{ number_format($payment->totalAmount, 2) }}</strong></td></tr>
        <tr><td><strong>Paid By</strong></td><td>{{ $payment->paymentMethod == 'cash' ? 'Cash' : 'Credit/ Debit Card' }}</td></tr>
        <tr><td><strong>Paid On</strong></td><td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i:s') }}</td></tr>
        <tr><td><strong>Voucher Used</strong></td><td>{{ $payment->vouchers ? $payment->vouchers->code : '-' }}</td></tr>
        <tr><td><strong>Status</strong></td><td style="color: {{ $payment->status == 'Completed' ? 'green' : 'red' }}; font-weight: bold;">{{ $payment->status }}</td></tr>
    </table>

    <h3 style="margin-top: 20px; color: #333;">🛒 Order Items</h3>
    <table class="order-table">
        <thead>
        <tr><th>Item</th><th>Quantity</th><th>Remark</th></tr>
        </thead>
        <tbody>
        @foreach($payment->orders->orderItems as $item)
            <tr>
                <td><strong>{{ $item->products->name }}</strong></td>
                <td>{{ $item->quantity }}</td>
                <td>
                    @php
                        $remark = json_decode($item->remark, true) ?? [];
                        $options = $remark['options'] ?? [];
                        $takeaway = $remark['takeaway'] ?? false;

                        $remarksList = [];

                        $remarksList[] = $takeaway ? 'Takeaway' : 'Dine In';

                        foreach ($options as $values) {
                            $remarksList = array_merge($remarksList, $values);
                        }
                    @endphp

                    <strong>{{ implode(', ', $remarksList) }}</strong>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} <strong>TastyByte</strong>. All rights reserved.</p>
    </div>
</div>
</body>
</html>
