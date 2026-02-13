<x-app-layout>
    <div class="p-6 max-w-5xl mx-auto">

        <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">
            Riwayat Transaksi
        </h1>

        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">

            <table class="w-full text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr class="text-gray-700 dark:text-gray-200">
                        <th class="p-3">Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200 divide-y dark:divide-gray-700">
                    @foreach($transactions as $trx)
                    <tr>
                        <td class="p-3">{{ $trx->transaction_code }}</td>
                        <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                        <td>Rp {{ number_format($trx->total) }}</td>
                        <td>
                            <a href="{{ route('transactions.show', $trx->id) }}" class="text-blue-600 dark:text-blue-400">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>