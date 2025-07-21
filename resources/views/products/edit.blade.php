<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Edit Product</h2>
            <a href="{{ route('products.index') }}"
               class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded transition shadow">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white p-6 rounded shadow-sm">
        <form action="{{ route('products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6 text-sm text-gray-700">
            @csrf
            @method('PUT')

            @include('products.form', [
                'product' => $product,
                'categories' => $categories,
                'attributes' => $attributes,
                'selectedAttributeValueIds' => $selectedAttributeValueIds,
            ])

            <div>
                <button type="submit"
                        class="bg-green-600 text-white px-5 py-2.5 rounded hover:bg-green-700 shadow text-sm">
                    💾 Update Product
                </button>
            </div>
        </form>
    </div>
</x-layouts.sidebar>
