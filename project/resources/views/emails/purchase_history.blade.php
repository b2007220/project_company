<!DOCTYPE html>
<html>

<head>
    <title>Purchase History</title>
</head>

<body>
    <h1>Hi {{ $user->name }},</h1>
    <p>Here is your purchase history and the total amount you have spent on our site.</p>

    <h2>Purchase History:</h2>
    <ul>
        @foreach ($orders as $order)
            <li>{{ $order->delivered_at }} - {{ $order->grand_total }} </li>
        @endforeach
    </ul>

    <h2>Total Amount Spent: ${{ $totalAmount }}</h2>
    <p>Thank you for shopping with us!</p>
</body>

</html>
