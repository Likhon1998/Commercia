<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">➕ Create Product</h2>
            <a href="{{ route('products.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow transition">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block font-medium">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label for="description" class="block font-medium">Description</label>
                <textarea name="description" id="description" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="price" class="block font-medium">Price</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label for="sku" class="block font-medium">SKU</label>
                <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="w-full border p-2 rounded">
            </div>

            <div>
                <label for="stock_qty" class="block font-medium">Stock Quantity</label>
                <input type="number" name="stock_qty" id="stock_qty" value="{{ old('stock_qty') }}" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label for="category_id" class="block font-medium">Category</label>
                <select name="category_id" id="category_id" class="w-full border p-2 rounded" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block font-medium">Status</label>
                <select name="status" id="status" class="w-full border p-2 rounded">
                    <option value="1" @selected(old('status') == '1')>Active</option>
                    <option value="0" @selected(old('status') == '0')>Inactive</option>
                </select>
            </div>

            <div>
                <label for="image" class="block font-medium">Upload Image</label>
                <input type="file" name="image" id="image" class="w-full border p-2 rounded">
            </div>

            <!-- ✅ Show Only Attributes as Checkboxes -->
            @if($attributes->count())
                <div>
                    <label class="block font-bold text-lg mb-2">Product Attributes</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach($attributes as $attribute)
                            <label class="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    name="attribute_ids[]"
                                    value="{{ $attribute->id }}"
                                    @if(is_array(old('attribute_ids')) && in_array($attribute->id, old('attribute_ids'))) checked @endif
                                >
                                <span>{{ $attribute->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create Product
            </button>
        </form>
    </div>
</x-layouts.sidebar>
