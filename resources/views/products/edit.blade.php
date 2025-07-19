<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">✏️ Edit Product</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            @include('products.form', [
                'product' => $product,
                'categories' => $categories,
                'attributes' => $attributes,
                'selectedAttributes' => $selectedAttributes,
            ])

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update Product
            </button>
        </form>
    </div>
</x-layouts.sidebar>
