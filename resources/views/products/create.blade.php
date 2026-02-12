<x-app-layout>
    <div class="p-6 text-gray-800 dark:text-gray-200">
        
        <h1 class="text-2xl font-bold mb-6">
            Tambah Produk
        </h1>

        <div class="max-w-xl bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">
                        Nama Produk
                    </label>
                    <input type="text" name="name"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Kode Produk --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">
                        Kode Produk
                    </label>
                    <input type="text" name="sku"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">
                        Harga
                    </label>
                    <input type="number" name="price"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Stok --}}
                <div class="mb-6">
                    <label class="block mb-1 font-medium">
                        Stok
                    </label>
                    <input type="number" name="stock"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 
                               text-white px-4 py-2 rounded-md 
                               transition duration-200">
                        Simpan
                    </button>

                    <a href="{{ route('products.index') }}"
                        class="border border-gray-400 px-4 py-2 rounded-md
                               hover:bg-gray-200 dark:hover:bg-gray-700
                               transition duration-200">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
