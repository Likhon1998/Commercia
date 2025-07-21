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

    <div class="py-6 max-w-6xl mx-auto">
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
                            <form action="{{ route('products.destroy', $product) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-red-600 font-medium flex items-center gap-1">
                                    🗑️ Delete
                                </button>
                            </form>
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
    </div>
</x-layouts.sidebar>
