<x-app-layout>
    <div class="p-6 text-gray-800 dark:text-gray-200">
        
        <h1 class="text-2xl font-bold mb-6">
            Edit Produk
        </h1>

        <div class="max-w-xl bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">
                        Nama Produk
                    </label>
                    <input type="text" name="name"
                        value="{{ $product->name }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kode Produk --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">
                        Kode Produk
                    </label>
                    <input type="text" name="sku"
                        value="{{ $product->sku }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="mb-4">
                    <label class="block mb-1 font-medium">
                        Harga
                    </label>
                    <input type="number" name="price"
                        value="{{ $product->price }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="mb-6">
                    <label class="block mb-1 font-medium">
                        Stok
                    </label>
                    <input type="number" name="stock"
                        value="{{ $product->stock }}"
                        class="w-full border border-gray-300 dark:border-gray-600 
                               rounded-md p-2 
                               bg-white dark:bg-gray-700
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 
                               text-white px-4 py-2 rounded-md 
                               transition duration-200">
                        Update
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
