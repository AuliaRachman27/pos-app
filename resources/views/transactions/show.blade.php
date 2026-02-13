<x-app-layout>
    <div class="p-6 max-w-md mx-auto">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

            <h2 class="text-center text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">
                STRUK PEMBAYARAN
            </h2>

            <p class="text-sm text-gray-700 dark:text-gray-300">Kode: {{ $transaction->transaction_code }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}</p>

            <hr class="my-3 dark:border-gray-600">

            @foreach($transaction->items as $item)
            <div class="flex justify-between text-sm 
                        text-gray-800 dark:text-gray-200">
                <span>{{ $item->product->name }} x{{ $item->qty }}</span>
                <span>Rp {{ number_format($item->subtotal) }}</span>
            </div>
            @endforeach

            <hr class="my-3 dark:border-gray-600">

            <div class="flex justify-between font-bold text-lg 
                        text-gray-800 dark:text-gray-200">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total) }}</span>
            </div>

            <div class="text-center mt-4">
                <button onclick="window.print()"
                    class="bg-green-600 text-white px-4 py-2 rounded">
                    Print Struk
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
