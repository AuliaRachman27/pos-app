<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
        <p class="text-sm text-gray-500">
            Welcome back to URBANPOS
        </p>
    </x-slot>

    <div class="py-12 text-gray-900 dark:text-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 p-4 shadow-sm sm:rounded-lg mb-6">
                <div class="flex flex-wrap gap-2 mb-4">
                    <a href="{{ route('dashboard', ['period' => 'today']) }}" class="px-4 py-2 rounded text-sm font medium
                        {{ ($period ?? '') == 'today'
                         ? 'bg-blue-600 text-white'
                         : 'bg-gray-200 dark:bg-gray-700 texg-gray-800 dark:text-gray-200' }}">
                         Hari ini
                    </a>

                    <a href="{{ route('dashboard', ['period' => '7days']) }}"
                        class="px-4 py-2 rounded text-sm font-medium
                        {{ ($period ?? '') == '7days'
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                        7 Hari Terakhir
                    </a>

                    <a href="{{ route('dashboard', ['period' => 'month']) }}"
                        class="px-4 py-2 rounded text-sm font-medium
                        {{ ($period ?? '') == 'month'
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                        Bulan Ini
                    </a>

                    <a href="{{ route('dashboard.export', [
                            'start_date' => $startDate ?? null,
                            'end_date'   => $endDate ?? null,
                            'period'     => $period ?? null,
                        ]) }}"
                        class="inline-flex items-center gap-2
                            bg-emerald-600 hover:bg-emerald-700
                            text-white font-semibold
                            px-4 py-2 rounded-lg
                            shadow-md hover:shadow-lg
                            transition duration-200">
                        Export Excel
                    </a>
                </div>
            
                <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col md:flex-row md:items-end gap-4">

                    <div class="flex-1">
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date"
                            value="{{ request('start_date') }}"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                    </div>

                    <div class="flex-1">
                        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date"
                            value="{{ $endDate ?? '' }}"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600">
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                            Filter
                        </button>
                    </div>

                </form>
            </div>

            <!-- CARD SUMMARY -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold">Total Omzet</h3>
                    <p class="text-2xl font-bold">
                        Rp {{ number_format($totalOmzet) }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold">Jumlah Transaksi</h3>
                    <p class="text-2xl font-bold">
                        {{ $totalTransactions }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 shadow-sm sm:rounded-lg">
                    <h3 class="text-lg font-semibold">Total Item Terjual</h3>
                    <p class="text-2xl font-bold">
                        {{ $totalItemsSold }}
                    </p>
                </div>

            </div>

            <!-- TABLE -->

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar Transaksi</h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2 text-left">Kode</th>
                            <th class="p-2 text-left">Total</th>
                            <th class="p-2 text-left">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactionsToday as $transaction)
                            <tr class="border-b">
                                <td class="p-2">{{ $transaction->transaction_code }}</td>
                                <td class="p-2">
                                    Rp {{ number_format($transaction->total) }}
                                </td>
                                <td class="p-2">
                                    {{ $transaction->created_at->format('H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center">
                                    Belum ada transaksi hari ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
