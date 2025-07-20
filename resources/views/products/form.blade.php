@php
    $isEdit = isset($product);
@endphp

@csrf

<div class="space-y-4">

    {{-- Product Name --}}
    <div>
        <label for="name" class="block font-medium">Product Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border p-2 rounded" required>
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block font-medium">Description</label>
        <textarea name="description" id="description" class="w-full border p-2 rounded" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    {{-- Price --}}
    <div>
        <label for="price" class="block font-medium">Price</label>
        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" class="w-full border p-2 rounded" required>
    </div>

    {{-- SKU --}}
    <div>
        <label for="sku" class="block font-medium">SKU</label>
        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku ?? '') }}" class="w-full border p-2 rounded">
    </div>

    {{-- Stock Quantity --}}
    <div>
        <label for="stock_qty" class="block font-medium">Stock Quantity</label>
        <input type="number" name="stock_qty" id="stock_qty" value="{{ old('stock_qty', $product->stock_qty ?? '') }}" class="w-full border p-2 rounded" required>
    </div>

    {{-- Category --}}
    <div>
        <label for="category_id" class="block font-medium">Category</label>
        <select name="category_id" id="category_id" class="w-full border p-2 rounded" required>
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Status --}}
    <div>
        <label for="status" class="block font-medium">Status</label>
        <select name="status" id="status" class="w-full border p-2 rounded" required>
            <option value="1" @selected(old('status', $product->status ?? '') == 1)>Active</option>
            <option value="0" @selected(old('status', $product->status ?? '') == 0)>Inactive</option>
        </select>
    </div>

    {{-- Product Image --}}
    <div>
        <label for="image" class="block font-medium">Product Image</label>
        <input type="file" name="image" id="image" class="w-full border p-2 rounded">
        @if($isEdit && $product->primaryImage)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-32 h-32 object-cover rounded border" alt="Current Image">
            </div>
        @endif
    </div>

    {{-- Attributes and Attribute Values --}}
    @if(isset($attributes) && $attributes->count())
    <div>
        <label class="block font-medium mb-2">Product Attributes</label>

        @foreach($attributes as $attribute)
            <div class="mb-4">
                <p class="font-semibold">{{ $attribute->name }}</p>
                <div class="flex flex-wrap gap-4 mt-1">
                    @foreach($attribute->values as $value)
                        <label class="inline-flex items-center space-x-2">
                            <input
                                type="checkbox"
                                name="attribute_value_ids[]"
                                value="{{ $value->id }}"
                                {{ in_array($value->id, old('attribute_value_ids', $selectedAttributeValueIds ?? [])) ? 'checked' : '' }}
                            >
                            <span>{{ $value->value }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @endif

</div>
