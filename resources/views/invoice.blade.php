<!DOCTYPE html>
<html>
<head>
    <title>Generated Invoice</title>
</head>
<body>
    <h1>Generated Invoice</h1>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Tax</th>
                <th>Line Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->item }}</td>
                    <td>{{ $invoice->quantity }}</td>
                    <td>{{ $invoice->price }}</td>
                    <td>{{ $invoice->tax }}</td>
                    <td>{{ $invoice->quantity * $invoice->price }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Subtotal without Tax:</td>
                <td>{{ $subtotalWithoutTax }}</td>
            </tr>
            <tr>
                <td colspan="4">Subtotal with Tax:</td>
                <td>{{ $subtotalWithTax }}</td>
            </tr>
            <tr>
                <td colspan="4">Discount:</td>
                <td>{{ $discount }}</td>
            </tr>
            <tr>
                <td colspan="4">Total Amount:</td>
                <td><h3>{{ $totalAmount }}</h3></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>