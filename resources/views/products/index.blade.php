<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">🛒 Products</h2>
            <a href="{{ route('products.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow transition">
               + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white border rounded-lg shadow p-4">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover rounded mb-3">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 mb-3">
                                No Image
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-gray-700 mb-1">{{ $product->category->name ?? 'No Category' }}</p>
                        <p class="text-gray-900 font-bold mb-3">${{ number_format($product->price, 2) }}</p>

                        <div class="flex justify-between text-sm">
                            <a href="{{ route('products.edit', $product) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-center text-gray-500 mt-10">No products available.</p>
        @endif
    </div>
</x-layouts.sidebar>
