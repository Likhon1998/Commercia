@php
    $isEdit = isset($product);
@endphp

@csrf

<div class="space-y-5 text-sm text-gray-700">

    
    <div>
        <label for="name" class="block font-medium">Product Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name"
            value="{{ old('name', $product->name ?? '') }}"
            class="w-full border rounded px-3 py-2" required>
    </div>

   
    <div>
        <label for="description" class="block font-medium">Description</label>
        <textarea name="description" id="description" rows="3"
            class="w-full border rounded px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

  
    <div>
        <label for="price" class="block font-medium">Price <span class="text-red-500">*</span></label>
        <input type="number" step="0.01" name="price" id="price"
            value="{{ old('price', $product->price ?? '') }}"
            class="w-full border rounded px-3 py-2" required>
    </div>

  
    <div>
        <label for="sku" class="block font-medium">SKU</label>
        <input type="text" name="sku" id="sku"
            value="{{ old('sku', $product->sku ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    
    <div>
        <label for="stock_qty" class="block font-medium">Stock Qty <span class="text-red-500">*</span></label>
        <input type="number" name="stock_qty" id="stock_qty"
            value="{{ old('stock_qty', $product->stock_qty ?? '') }}"
            class="w-full border rounded px-3 py-2" required>
    </div>

  
    <div>
        <label for="category_id" class="block font-medium">Category <span class="text-red-500">*</span></label>
        <select name="category_id" id="category_id"
            class="w-full border rounded px-3 py-2" required>
            <option value="">Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    
    <div>
        <label for="status" class="block font-medium">Status <span class="text-red-500">*</span></label>
        <select name="status" id="status"
            class="w-full border rounded px-3 py-2" required>
            <option value="1" @selected(old('status', $product->status ?? '') == 1)>Active</option>
            <option value="0" @selected(old('status', $product->status ?? '') == 0)>Inactive</option>
        </select>
    </div>

   
    <div>
        <label for="image" class="block font-medium">Product Image</label>
        <input type="file" name="image" id="image"
            class="w-full border rounded px-3 py-2">
        @if($isEdit && $product->primaryImage)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                    class="w-28 h-28 object-cover rounded border"
                    alt="Current Image">
            </div>
        @endif
    </div>

    @if(isset($attributes) && $attributes->count())
    <div>
        <label class="block font-medium mb-1">Product Attributes</label>
        <div class="space-y-3">
            @foreach($attributes as $attribute)
                <div>
                    <p class="font-semibold text-sm mb-1">{{ $attribute->name }}</p>
                    <div class="flex flex-wrap gap-4">
                        @foreach($attribute->values as $value)
                            <label class="inline-flex items-center gap-2">
                                <input type="checkbox" name="attribute_value_ids[]"
                                    value="{{ $value->id }}"
                                    {{ in_array($value->id, old('attribute_value_ids', $selectedAttributeValueIds ?? [])) ? 'checked' : '' }}>
                                <span>{{ $value->value }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
