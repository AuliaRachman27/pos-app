<!DOCTYPE html>
<html>
<head>
    <title>Struk - {{ $transaction->transaction_id }}</title>
    <style>
        body { font-family: monospace; width: 300px; margin: auto; }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 8px 0; }
    </style>
</head>
<body onload="window.print()">

    <div class="center">
        <h3>Basic PoS</h3>
        <p>{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
        <p>Kode: {{ $transaction->transaction_code }}</p>
    </div>

    <div class="line"></div>

    @foreach($transaction->items as $item)
        <p>
            {{ $item->product->name }} <br>
            {{ $item->qty }} x {{ number_format($item->price) }}
            = {{ number_format($item->qty * $item->price) }}
        </p>
    @endforeach

    <div class="line"></div>

    <p><strong>Total: Rp {{ number_format($transaction->total) }}</strong></p>

    <div class="center">
        <p>Terima Kasih 🙏</p>
    </div>

</body>
</html>
