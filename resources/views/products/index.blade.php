<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">🛍️ Products</h2>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center bg-gray-600 text-white px-3 py-1.5 rounded hover:bg-gray-700 text-sm">
                + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto" x-data="{ confirmingProductId: null }">
        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($products as $product)
                    <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition p-3">
                        <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded overflow-hidden">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="object-cover w-full h-full">
                            @else
                                <div class="flex items-center justify-center w-full h-full text-gray-500 text-sm">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <div class="mt-3">
                            <h3 class="text-base font-medium text-gray-800 truncate">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-sm">
                            <span class="text-green-700 font-semibold">${{ number_format($product->price, 2) }}</span>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                {{ $product->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="mt-3 flex justify-between text-xs text-gray-600">
                            <a href="{{ route('products.edit', $product) }}"
                               class="hover:text-blue-600 font-medium flex items-center gap-1">
                                ✏️ Edit
                            </a>

                            <a href="{{ route('products.show', $product) }}"
                               class="hover:text-indigo-600 font-medium flex items-center gap-1">
                                👁️ Show
                            </a>

                            <!-- Improved Delete Button -->
                            <button @click.prevent="confirmingProductId = {{ $product->id }}"
                                    class="flex items-center gap-1 px-2 py-1 bg-red-100 text-red-700 text-xs rounded hover:bg-red-200 hover:text-red-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-6 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-center text-gray-400 mt-10">No products available.</p>
        @endif

        <!-- Confirmation Modal -->
        <div x-show="confirmingProductId"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
             x-cloak>
            <div class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Delete Confirmation</h2>
                <p class="text-sm text-gray-600">Are you sure you want to delete this product? This action cannot be undone.</p>

                <div class="mt-4 flex justify-end gap-2">
                    <button @click="confirmingProductId = null"
                            class="px-3 py-1 text-sm bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <form :action="`/products/${confirmingProductId}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                            Confirm Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.sidebar>
