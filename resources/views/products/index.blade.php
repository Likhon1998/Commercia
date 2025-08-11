<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">📦 Products</h2>
            <a href="{{ route('products.create') }}"
               class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                + Add New Product
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 bg-white p-6 rounded shadow">

        <!-- Search form -->
        <form method="GET" action="{{ route('products.index') }}" class="mb-4 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by product name or model"
                   class="flex-grow border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                Search
            </button>
        </form>

        <!-- Products table -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded">
                <thead class="bg-indigo-100 text-indigo-700 font-semibold">
                    <tr>
                        <th class="border px-4 py-2 text-center">
                            <input type="checkbox" onclick="toggleAll(this)">
                        </th>
                        <th class="border px-4 py-2 text-left">Sl</th>
                        <th class="border px-4 py-2 text-left">Product Name</th>
                        <th class="border px-4 py-2 text-left">Product Model</th>
                        <th class="border px-4 py-2 text-left">Category</th>
                        <th class="border px-4 py-2 text-left">Sub Category</th>
                        <th class="border px-4 py-2 text-left">Brand</th>
                        <th class="border px-4 py-2 text-left">Barcode/QR-code</th>
                        <th class="border px-4 py-2 text-left">Supplier Name</th>
                        <th class="border px-4 py-2 text-right">Sale Price (BDT)</th>
                        <th class="border px-4 py-2 text-right">Supplier Price (BDT)</th>
                        <th class="border px-4 py-2 text-center">Image</th>
                        <th class="border px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="hover:bg-indigo-50">
                        <td class="border px-4 py-2 text-center">
                            <input type="checkbox" name="selected_products[]" value="{{ $product->id }}">
                        </td>
                        <td class="border px-4 py-2">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->model ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $product->category ? $product->category->name : '-' }}</td>
                        <td class="border px-4 py-2">{{ $product->subCategory ? $product->subCategory->name : '-' }}</td>
                        <td class="border px-4 py-2">{{ $product->brand ? $product->brand->name : '-' }}</td>
                        <td class="border px-4 py-2">{{ $product->barcode_source ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $product->supplier ? $product->supplier->name : '-' }}</td>
                        <td class="border px-4 py-2 text-right">{{ number_format($product->selling_price_inc_vat ?? 0, 2) }}</td>
                        <td class="border px-4 py-2 text-right">{{ number_format($product->cost_price_inc_vat ?? 0, 2) }}</td>
                        <td class="border px-4 py-2 text-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                            @else
                                <span class="text-gray-400 text-sm">No Image</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center space-x-2 whitespace-nowrap">
                            <a href="{{ route('products.show', $product->id) }}"
                               class="text-green-600 hover:text-green-900 font-semibold text-sm">Show</a>
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="border px-4 py-6 text-center text-gray-500">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>

    <script>
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(cb => cb.checked = source.checked);
        }
    </script>
</x-layouts.sidebar>
