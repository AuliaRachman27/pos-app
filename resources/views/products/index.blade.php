<x-app-layout>
    <div class="p-6 text-gray-800 dark:text-gray-200">
        
        <h1 class="text-2xl font-bold mb-4">
            Daftar Produk
        </h1>

        <a href="{{ route('products.create') }}"
           class="inline-block border border-blue-600 text-blue-600 
                  hover:bg-blue-600 hover:text-white 
                  px-4 py-2 rounded-md 
                  transition duration-200">
            + Tambah Produk
        </a>

        <table class="table-auto w-full mt-6 border border-gray-300 dark:border-gray-700">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-700">
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Kode Produk</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-800">
                        <td class="border px-4 py-2 border-gray-300 dark:border-gray-700">
                            {{ $product->name }}
                        </td>
                        <td class="border px-4 py-2 border-gray-300 dark:border-gray-700">
                            {{ $product->sku }}
                        </td>
                        <td class="border px-4 py-2 border-gray-300 dark:border-gray-700">
                            {{ number_format($product->price) }}
                        </td>
                        <td class="border px-4 py-2 border-gray-300 dark:border-gray-700">
                            {{ $product->stock }}
                        </td>
                        <td class="border px-4 py-2 border-gray-300 dark:border-gray-700">
                            <div class="flex gap-2">

                                <a href="{{ route('products.edit', $product->id) }}"
                                class="border border-yellow-500 text-yellow-600 
                                        hover:bg-yellow-500 hover:text-white 
                                        px-3 py-1 rounded-md text-sm transition">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}" 
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="border border-red-500 text-red-600 
                                            hover:bg-red-500 hover:text-white 
                                            px-3 py-1 rounded-md text-sm transition">
                                        Delete
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            Belum ada produk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>
