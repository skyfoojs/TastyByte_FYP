<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - TastyByte</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h2 { color: #3B82F6; margin: 0; }
        .details-table, .order-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .details-table td, .order-table th, .order-table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .order-table th { background-color: #f8f8f8; }
        .footer { text-align: center; color: #777; font-size: 12px; margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; }
        .btn { display: inline-block; padding: 10px 20px; background: #3B82F6; color: #FFFFFF; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>TastyByte Invoice</h2>
        <p>Thank you for your purchase!</p>
    </div>

    <table class="details-table">
        <tr><td><strong>Invoice No:</strong></td><td>#{{ $payment->paymentID }}</td></tr>
        <tr><td><strong>Order ID:</strong></td><td>#{{ $payment->orders->orderID }}</td></tr>
        <tr><td><strong>Payment Method:</strong></td><td>{{ $payment->paymentMethod }}</td></tr>
        <tr>
            <td><strong>Status:</strong></td>
            <td style="color: {{ $payment->status == 'Completed' ? 'green' : 'red' }}; font-weight: bold;">
                {{ $payment->status }}
            </td>
        </tr>
        <tr><td><strong>Total Amount:</strong></td><td>RM{{ number_format($payment->totalAmount, 2) }}</td></tr>
        <tr><td><strong>Date:</strong></td><td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i:s') }}</td></tr>
    </table>

    <h3 style="margin-top: 20px;">Order Items</h3>
    <table class="order-table">
        <thead>
        <tr><th>Item</th><th>Quantity</th><th>Remark</th></tr>
        </thead>
        <tbody>
        @foreach($payment->orders->orderItems as $item)
            <tr>
                <td>{{ $item->products->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                    @php $remark = json_decode($item->remark, true); @endphp
                    @if(isset($remark['options']))
                        @foreach($remark['options'] as $option => $values)
                            <strong>{{ $option }}:</strong> {{ implode(', ', $values) }}<br>
                        @endforeach
                    @endif
                    @if(isset($remark['takeaway']) && $remark['takeaway'])
                        <strong>Takeaway:</strong> Yes
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="text-align: center; margin-top: 20px;">
        <a href="#" class="btn">View Invoice</a>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} TastyByte. All rights reserved.</p>
    </div>
</div>
</body>
</html>
