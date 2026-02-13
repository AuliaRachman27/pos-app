<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Transaksi Baru</h1>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="mt-6 bg-white dark:bg-gray-800 p-4 rounded shadow">

                    <div class="flex gap-3 mb-4">
                        <select id="productSelect"
                            class="border rounded p-2 w-full dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                        data-name="{{ $product->name }}"
                                        data-stock="{{ $product->stock }}">
                                    {{ $product->name }} - Rp {{ number_format($product->price) }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>

                        <input type="number" id="qtyInput" placeholder="Qty" class="border rounded p-2 w-24 dark:bg-gray-700 dark:text-white">
                        <button type="button" onclick="addToCart()" class="bg-blue-600 text-white px-4 rounded">Tambah</button>
                    </div>

                    <!-- CART TABLE -->
                    <table class="w-full mb-4 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr class="text-gray-700 dark:text-gray-200">
                                <th class="p-2">Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cartBody" class="text-gray-800 dark:text-gray-200"></tbody>
                    </table>

                    <!-- TOTAL -->
                    <div class="flex justify-between font-semibold text-lg mb-3">
                        <span class="text-gray-700 dark:text-gray-300">Total</span>
                        <span id="totalDisplay" class="text-green-600">Rp 0</span>
                    </div>

                    <!-- PAY -->
                    <div class="mb-3">
                        <label class="text-gray-700 dark:text-gray-300">Bayar</label>
                        <input type="number" name="pay" id="payInput"
                            class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <span class="text-gray-700 dark:text-gray-300">Kembalian: </span>
                        <span id="changeDisplay" class="text-gray-700 dark:text-gray-300 font-semibold">Rp 0</span>
                    </div>

                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded">
                        Proses Transaksi
                    </button>

                </div>
            </form>
        </div>
    </div>

    <script>
        let cart = [];
        let total = 0;

        function addToCart(){
            let select = document.getElementById('productSelect');
            let qty = parseInt(document.getElementById('qtyInput').value);
            let id = select.value;

            if(!id || !qty) return;

            let price = parseInt(select.selectedOptions[0].dataset.price);
            let name = select.selectedOptions[0].dataset.name;
            let stock = parseInt(select.selectedOptions[0].dataset.stock);

            if (qty > stock) {
                alert('Stok tidak cukup!');
                return;
            }

            let subtotal = price * qty;
            total += subtotal;

            cart.push({ id, qty });

            let row = `
                <tr>
                    <td class="p-2">${name}</td>
                    <td>${qty}</td>
                    <td>Rp ${price.toLocaleString()}</td>
                    <td>Rp ${subtotal.toLocaleString()}</td>
                    <td><button type="button" onclick="this.closest('tr').remove()">X</button></td>
                </tr>
                <input type="hidden" name="products[${cart.length-1}][id]" value="${id}">
                <input type="hidden" name="products[${cart.length-1}][qty]" value="${qty}">
            `;

            document.getElementById('cartBody').innerHTML += row;

            document.getElementById('totalDisplay').innerText = "Rp " + total.toLocaleString();
        }

        document.getElementById('payInput').addEventListener('input', function() {
            let pay = parseInt(this.value) || 0;
            let change = pay - total;
            document.getElementById('changeDisplay').innerText = "Rp " + change.toLocaleString();
        });
    </script>

</x-app-layout>