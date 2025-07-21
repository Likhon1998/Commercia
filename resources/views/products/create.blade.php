<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Create New Product</h2>
            <a href="{{ route('products.index') }}"
               class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded transition shadow">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white p-6 rounded shadow-sm">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">

                {{-- Left Side --}}
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block font-medium">
                            Product Name <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-blue-500 focus:border-blue-500">
                        @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block font-medium">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full border px-3 py-2 rounded resize-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block font-medium">
                            Category <span class="text-red-600">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                                class="w-full border px-3 py-2 rounded bg-white">
                            <option value="">-- Select --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="block font-medium">Status</label>
                        <select name="status" id="status"
                                class="w-full border px-3 py-2 rounded bg-white">
                            <option value="1" @selected(old('status') == '1')>Active</option>
                            <option value="0" @selected(old('status') == '0')>Inactive</option>
                        </select>
                        @error('status') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Right Side --}}
                <div class="space-y-4">
                    <div>
                        <label for="price" class="block font-medium">
                            Price <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="price" step="0.01" id="price" required
                               value="{{ old('price') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-blue-500 focus:border-blue-500">
                        @error('price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sku" class="block font-medium">SKU</label>
                        <input type="text" name="sku" id="sku"
                               value="{{ old('sku') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-blue-500 focus:border-blue-500">
                        @error('sku') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="stock_qty" class="block font-medium">
                            Stock Quantity <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="stock_qty" id="stock_qty" required
                               value="{{ old('stock_qty') }}"
                               class="w-full border px-3 py-2 rounded focus:ring-blue-500 focus:border-blue-500">
                        @error('stock_qty') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image" class="block font-medium">Product Image</label>
                        <input type="file" name="image" id="image"
                               class="w-full border px-3 py-2 rounded file:mr-3 file:py-1 file:px-3 file:border-0 file:bg-blue-600 file:text-white file:rounded file:text-sm">
                        @error('image') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Attributes --}}
            @if($attributes->count())
                <div class="mt-8">
                    <label class="block font-medium text-sm mb-2">Select Product Attributes</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        @foreach($attributes as $attribute)
                            <div class="border rounded px-4 py-3">
                                <p class="font-semibold text-gray-800 mb-1">{{ $attribute->name }}</p>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($attribute->values as $value)
                                        <label class="inline-flex items-center gap-1 text-gray-700">
                                            <input type="checkbox"
                                                   name="attribute_value_ids[]"
                                                   value="{{ $value->id }}"
                                                   {{ is_array(old('attribute_value_ids')) && in_array($value->id, old('attribute_value_ids')) ? 'checked' : '' }}>
                                            <span>{{ $value->value }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-8">
                <button type="submit"
                        class="bg-green-600 text-white px-5 py-2.5 rounded hover:bg-green-700 text-sm shadow">
                    ✅ Create Product
                </button>
            </div>
        </form>
    </div>
</x-layouts.sidebar>
