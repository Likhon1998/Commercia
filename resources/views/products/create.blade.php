<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">➕ Create New Product</h2>
            <a href="{{ route('products.index') }}"
               class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 bg-white p-8 rounded shadow-md">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Product Details Section -->
            <section class="space-y-4">
                <h3 class="text-lg font-semibold border-b pb-1 mb-3">Product Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- Product Type -->
                    <div>
                        <label for="product_type" class="block text-sm font-medium mb-1">Product Type <span class="text-red-600">*</span></label>
                        <select name="product_type" id="product_type" required
                            class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            <option value="normal" @selected(old('product_type') == 'normal')>Normal</option>
                            <option value="combo" @selected(old('product_type') == 'combo')>Combo</option>
                            <option value="variant" @selected(old('product_type') == 'variant')>Variant</option>
                        </select>
                        @error('product_type') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-1">Product Name <span class="text-red-600">*</span></label>
                        <input type="text" name="name" id="name" required
                            value="{{ old('name') }}"
                            placeholder="Enter product name"
                            class="w-full border rounded px-2 py-1 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none" />
                        @error('name') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Model -->
                    <div>
                        <label for="model" class="block text-sm font-medium mb-1">Model</label>
                        <input type="text" name="model" id="model"
                            value="{{ old('model') }}"
                            placeholder="Model (optional)"
                            class="w-full border rounded px-2 py-1 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none" />
                        @error('model') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand_id" class="block text-sm font-medium mb-1">Brand</label>
                        <select name="brand_id" id="brand_id"
                            class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            <option value="">-- Select Brand --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Minimum Qty Alert -->
                    <div>
                        <label for="min_qty_alert" class="block text-sm font-medium mb-1">Minimum Qty Alert</label>
                        <input type="number" name="min_qty_alert" id="min_qty_alert" min="0"
                            value="{{ old('min_qty_alert', 0) }}"
                            class="w-full border rounded px-2 py-1 text-sm focus:ring-1 focus:ring-blue-400 focus:outline-none" />
                        @error('min_qty_alert') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                  <!-- Category -->
                <div>
                  <label for="category_id" class="block text-sm font-medium mb-1">Category <span class="text-red-600">*</span></label>
                  <select name="category_id" id="category_id" required
                      class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-blue-400 focus:outline-none">
                      <option value="">-- Select Category --</option>
                      <!-- Options will be dynamically populated -->
                  </select>
                  @error('category_id') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Sub Category -->
                <div>
                  <label for="sub_category_id" class="block text-sm font-medium mb-1">Sub Category</label>
                  <select name="sub_category_id" id="sub_category_id"
                      class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-blue-400 focus:outline-none">
                      <option value="">-- Select Sub Category --</option>
                      <!-- Options will be dynamically populated -->
                  </select>
                  @error('sub_category_id') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                    <!-- Unit -->
                    <div>
                        <label for="unit_id" class="block text-sm font-medium mb-1">Unit</label>
                        <select name="unit_id" id="unit_id"
                            class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            <option value="">-- Select Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" @selected(old('unit_id') == $unit->id)>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Supplier -->
                    <div>
                        <label for="supplier_id" class="block text-sm font-medium mb-1">Supplier</label>
                        <select name="supplier_id" id="supplier_id"
                            class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-blue-400 focus:outline-none">
                            <option value="">-- Select Supplier --</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Image Upload & Preview -->
                    <div>
                        <label for="image" class="block text-sm font-medium mb-1">Product Image</label>
                        <div class="flex items-center space-x-3">
                            <div id="imagePreview"
                                class="w-24 h-24 border border-gray-300 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                                No Image
                            </div>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="text-xs border rounded px-2 py-1 focus:ring-1 focus:ring-blue-300 focus:outline-none" />
                        </div>
                        @error('image') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium mb-1">Details</label>
                        <textarea name="description" id="description" rows="3"
                            placeholder="Enter product details"
                            class="w-full border rounded px-2 py-1 text-sm resize-none focus:ring-1 focus:ring-blue-400 focus:outline-none">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>
            </section>

         <!-- VAT & Pricing Section -->
<section class="space-y-4 bg-green-50 p-4 rounded-md border border-green-300">
  <h3 class="text-lg font-semibold border-b border-green-400 pb-1 mb-3 text-green-700">VAT & Pricing</h3>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <!-- VAT Type -->
    <div>
      <label for="vat_type" class="block text-sm font-semibold mb-1 text-green-800">VAT Type <span class="text-red-600">*</span></label>
      <select id="vat_type" name="vat_type" required
          class="w-full border border-green-300 rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-green-500 focus:outline-none">
          <option value="">-- Select VAT Type --</option>
          <option value="vat" @selected(old('vat_type') == 'vat')>Individual VAT</option>
          <option value="group" @selected(old('vat_type') == 'group')>VAT Group</option>
      </select>
      @error('vat_type') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- VAT Dropdown -->
    <div>
      <label for="vat_id" class="block text-sm font-semibold mb-1 text-green-800">Select VAT <span class="text-red-600">*</span></label>
      <select id="vat_id" name="vat_id" required disabled
          class="w-full border border-green-300 rounded px-2 py-1 text-sm bg-gray-100 cursor-not-allowed focus:outline-none">
          <option value="">-- Select VAT --</option>
          <!-- VAT options loaded dynamically by JS -->
      </select>
      @error('vat_id') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Cost Price Type -->
    <div>
      <label class="block text-sm font-semibold mb-1 text-green-800">Cost Price Type <span class="text-red-600">*</span></label>
      <div class="flex items-center gap-6 text-sm">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="cost_price_type" value="inclusive" id="cost_price_inclusive_radio" checked
              class="form-radio text-green-600" />
          <span class="ml-2">Inclusive VAT</span>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="cost_price_type" value="exclusive" id="cost_price_exclusive_radio"
              class="form-radio text-green-600" />
          <span class="ml-2">Exclusive VAT</span>
        </label>
      </div>
      @error('cost_price_type') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Cost Price Inclusive --}}
    <div>
      <label for="cost_price_inclusive" class="block text-sm font-semibold mb-1 text-green-800">Cost Price (Incl. VAT)</label>
      <input type="number" step="0.01" min="0" id="cost_price_inclusive" name="cost_price_inclusive" required
        value="{{ old('cost_price_inclusive') }}"
        class="w-full border border-green-300 rounded px-2 py-1 text-sm focus:ring-1 focus:ring-green-500 focus:outline-none" />
      @error('cost_price_inclusive') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Cost Price Exclusive --}}
    <div>
      <label for="cost_price_exclusive" class="block text-sm font-semibold mb-1 text-green-800">Cost Price (Excl. VAT)</label>
      <input type="number" step="0.01" min="0" id="cost_price_exclusive" name="cost_price_exclusive" required disabled
        value="{{ old('cost_price_exclusive') }}"
        class="w-full border border-green-300 rounded px-2 py-1 text-sm bg-gray-100 cursor-not-allowed" />
      @error('cost_price_exclusive') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Profit Margin --}}
    <div>
      <label for="profit_margin" class="block text-sm font-semibold mb-1 text-green-800">Profit Margin (%)</label>
      <input type="number" step="0.01" min="0" max="100" id="profit_margin" name="profit_margin" required
        value="{{ old('profit_margin') }}"
        class="w-full border border-green-300 rounded px-2 py-1 text-sm focus:ring-1 focus:ring-green-500 focus:outline-none" />
      @error('profit_margin') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Discount Type --}}
    <div>
      <label for="discount_type" class="block text-sm font-semibold mb-1 text-green-800">Discount Type</label>
      <select id="discount_type" name="discount_type"
        class="w-full border border-green-300 rounded px-2 py-1 text-sm bg-white focus:ring-1 focus:ring-green-500 focus:outline-none">
        <option value="percentage" @selected(old('discount_type') == 'percentage' || old('discount_type') === null)>Percentage (%)</option>
        <option value="amount" @selected(old('discount_type') == 'amount')>Fixed Amount</option>
      </select>
      @error('discount_type') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Discount Value --}}
    <div>
      <label for="discount_value" id="discount_value_label" class="block text-sm font-semibold mb-1 text-green-800">
        Discount (%)</label>
      <input type="number" step="0.01" min="0" max="100" id="discount_value" name="discount_value" placeholder="Enter discount %"
        value="{{ old('discount_value') }}"
        class="w-full border border-green-300 rounded px-2 py-1 text-sm focus:ring-1 focus:ring-green-500 focus:outline-none" />
      @error('discount_value') <p class="text-red-600 text-[10px] mt-1">{{ $message }}</p> @enderror
    </div>
<div>
  <label for="selling_price" class="block text-sm font-semibold mb-1 text-green-800">Selling Price</label>
  <input 
    type="number" 
    step="0.01" 
    min="0" 
    id="selling_price" 
    name="selling_price" 
    readonly
    value="{{ old('selling_price') }}"
    aria-label="Selling Price"
    class="w-full border border-green-300 rounded px-2 py-1 text-sm bg-gray-100" 
  />
</div>


  </div>
</section>


<!-- Other Details Section -->
<section class="space-y-6 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
  <h3 class="text-lg font-semibold border-b border-indigo-500 pb-2 mb-5 text-indigo-700">
    Other Details
  </h3>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Barcode -->
    <div>
      <label class="block text-sm font-semibold mb-2 text-gray-800">Barcode <span class="text-red-600">*</span></label>
      <div class="flex items-center space-x-3">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_barcode" value="1" id="barcode_yes" class="hidden peer" @checked(old('is_barcode')=='1') required />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-indigo-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-indigo-600
                   select-none text-xs font-semibold transition">
            YES
          </div>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_barcode" value="0" id="barcode_no" class="hidden peer" @checked(old('is_barcode')=='0') />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-red-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-red-600
                   select-none text-xs font-semibold transition">
            NO
          </div>
        </label>
      </div>
      @error('is_barcode') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Barcode Type -->
    <div>
      <label for="barcode_type" class="block text-sm font-semibold mb-2 text-gray-800">Barcode Type</label>
      <input type="text" name="barcode_type" id="barcode_type"
             value="{{ old('barcode_type') }}"
             placeholder="e.g. CODE128, QR"
             class="w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
      @error('barcode_type') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Warranty -->
    <div>
      <label class="block text-sm font-semibold mb-2 text-gray-800">Warranty <span class="text-red-600">*</span></label>
      <div class="flex items-center space-x-3">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_warranty" value="1" class="hidden peer" @checked(old('is_warranty')=='1') required />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-indigo-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-indigo-600
                   select-none text-xs font-semibold transition">
            YES
          </div>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_warranty" value="0" class="hidden peer" @checked(old('is_warranty')=='0') />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-red-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-red-600
                   select-none text-xs font-semibold transition">
            NO
          </div>
        </label>
      </div>
      @error('is_warranty') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Salable -->
    <div>
      <label class="block text-sm font-semibold mb-2 text-gray-800">Salable <span class="text-red-600">*</span></label>
      <div class="flex items-center space-x-3">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_salable" value="1" class="hidden peer" @checked(old('is_salable', '1') == '1') required />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-indigo-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-indigo-600
                   select-none text-xs font-semibold transition">
            YES
          </div>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_salable" value="0" class="hidden peer" @checked(old('is_salable') == '0') />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-red-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-red-600
                   select-none text-xs font-semibold transition">
            NO
          </div>
        </label>
      </div>
      @error('is_salable') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Expirable -->
    <div>
      <label class="block text-sm font-semibold mb-2 text-gray-800">Expirable <span class="text-red-600">*</span></label>
      <div class="flex items-center space-x-3">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_expirable" value="1" class="hidden peer" @checked(old('is_expirable')=='1') required />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-indigo-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-indigo-600
                   select-none text-xs font-semibold transition">
            YES
          </div>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_expirable" value="0" class="hidden peer" @checked(old('is_expirable')=='0') />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-red-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-red-600
                   select-none text-xs font-semibold transition">
            NO
          </div>
        </label>
      </div>
      @error('is_expirable') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Serviceable -->
    <div>
      <label class="block text-sm font-semibold mb-2 text-gray-800">Serviceable <span class="text-red-600">*</span></label>
      <div class="flex items-center space-x-3">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_serviceable" value="1" class="hidden peer" @checked(old('is_serviceable')=='1') required />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-indigo-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-indigo-600
                   select-none text-xs font-semibold transition">
            YES
          </div>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="is_serviceable" value="0" class="hidden peer" @checked(old('is_serviceable')=='0') />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-red-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-red-600
                   select-none text-xs font-semibold transition">
            NO
          </div>
        </label>
      </div>
      @error('is_serviceable') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- HSN Code -->
    <div>
      <label for="hsn_code" class="block text-sm font-semibold mb-2 text-gray-800">HSN Code</label>
      <input type="text" name="hsn_code" id="hsn_code"
             value="{{ old('hsn_code') }}"
             class="w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
      @error('hsn_code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Show on Website -->
    <div>
      <label class="block text-sm font-semibold mb-2 text-gray-800">Show on Website <span class="text-red-600">*</span></label>
      <div class="flex items-center space-x-3">
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="show_on_website" value="1" class="hidden peer" @checked(old('show_on_website')=='1') required />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-indigo-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-indigo-600
                   select-none text-xs font-semibold transition">
            YES
          </div>
        </label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="radio" name="show_on_website" value="0" class="hidden peer" @checked(old('show_on_website')=='0') />
          <div
            class="w-12 text-center py-1 rounded cursor-pointer
                   peer-checked:bg-red-600 peer-checked:text-white
                   border border-gray-300 peer-checked:border-red-600
                   select-none text-xs font-semibold transition">
            NO
          </div>
        </label>
      </div>
      @error('show_on_website') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Near Expiry Days -->
    <div>
      <label for="near_expiry_days" class="block text-sm font-semibold mb-2 text-gray-800">Near Expiry (Days)</label>
      <input type="number" name="near_expiry_days" id="near_expiry_days" min="0"
             value="{{ old('near_expiry_days') }}"
             class="w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
      @error('near_expiry_days') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Warning Expiry Days -->
    <div>
      <label for="warning_expiry_days" class="block text-sm font-semibold mb-2 text-gray-800">Warning Expiry (Days)</label>
      <input type="number" name="warning_expiry_days" id="warning_expiry_days" min="0"
             value="{{ old('warning_expiry_days') }}"
             class="w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
      @error('warning_expiry_days') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Status -->
    <div>
  <label for="status" class="block text-sm font-semibold mb-2 text-gray-800">
    Status <span class="text-red-600">*</span>
  </label>
  <select
    name="status"
    id="status"
    required
    class="w-full border rounded px-2 py-1 text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
  >
    <option value="1" @selected(old('status', '1') === '1')>Active</option>
    <option value="0" @selected(old('status') === '0')>Inactive</option>
  </select>
  @error('status')
    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
  @enderror
</div>

    <!-- Tags -->
    <div class="md:col-span-3">
      <label for="tags" class="block text-sm font-semibold mb-2 text-gray-800">Tags</label>
      <input type="text" name="tags" id="tags"
             value="{{ old('tags') }}"
             placeholder="Comma separated"
             class="w-full border rounded px-2 py-1 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
      @error('tags') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

  </div>

  <!-- Submit Button -->
  <div class="mt-6">
    <button type="submit"
            class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded shadow transition">
      Save Product
    </button>
  </div>
</section>
</form>

   <script>
document.addEventListener('DOMContentLoaded', () => {
    const brandSelect = document.getElementById('brand_id');
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');

    const categories = @json($categories);
    const vats = @json($vats);
    const vatGroups = @json($vatGroups);

    const parentCategories = categories.filter(cat => cat.parent_id === null);

    function populateCategories(categoriesList) {
        categorySelect.innerHTML = '<option value="">-- Select Category --</option>';
        categoriesList.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.name;
            categorySelect.appendChild(option);
        });
        categorySelect.disabled = categoriesList.length === 0;
    }

    brandSelect.addEventListener('change', () => {
        if (!brandSelect.value) {
            categorySelect.innerHTML = '<option value="">-- Select Category --</option>';
            categorySelect.disabled = true;
            subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
            subCategorySelect.disabled = true;
            return;
        }
        populateCategories(parentCategories);
        subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
        subCategorySelect.disabled = true;
    });

    categorySelect.addEventListener('change', () => {
        const selectedCategoryId = categorySelect.value;
        if (!selectedCategoryId) {
            subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
            subCategorySelect.disabled = true;
            return;
        }
        const filteredSubCategories = categories.filter(cat => String(cat.parent_id) === selectedCategoryId);
        subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
        filteredSubCategories.forEach(sub => {
            const option = document.createElement('option');
            option.value = sub.id;
            option.textContent = sub.name;
            subCategorySelect.appendChild(option);
        });
        subCategorySelect.disabled = filteredSubCategories.length === 0;
    });

    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.style.backgroundImage = `url(${e.target.result})`;
                imagePreview.textContent = '';
                imagePreview.style.backgroundSize = 'cover';
                imagePreview.style.backgroundPosition = 'center';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.backgroundImage = '';
            imagePreview.textContent = 'No Image';
        }
    });

    const vatTypeSelect = document.getElementById('vat_type');
    const vatSelect = document.getElementById('vat_id');
    const costPriceInclusiveInput = document.getElementById('cost_price_inclusive');
    const costPriceExclusiveInput = document.getElementById('cost_price_exclusive');
    const costPriceTypeRadios = document.getElementsByName('cost_price_type');
    const profitMarginInput = document.getElementById('profit_margin');
    const discountTypeSelect = document.getElementById('discount_type');
    const discountValueInput = document.getElementById('discount_value');
    const sellingPriceInput = document.getElementById('selling_price');

    function populateVatOptions(type) {
        vatSelect.innerHTML = '<option value="">-- Select VAT --</option>';
        vatSelect.disabled = true;
        if (type === 'vat') {
            vats.forEach(v => {
                const option = document.createElement('option');
                option.value = v.id;
                option.textContent = v.name + ' (' + v.percentage + '%)';
                option.setAttribute('data-vat-percent', v.percentage);
                vatSelect.appendChild(option);
            });
            vatSelect.disabled = false;
        } else if (type === 'group') {
            vatGroups.forEach(g => {
                const option = document.createElement('option');
                option.value = g.id;
                option.textContent = g.name + ' (' + g.percentage + '%)';
                option.setAttribute('data-vat-percent', g.percentage);
                vatSelect.appendChild(option);
            });
            vatSelect.disabled = false;
        }
    }

    vatTypeSelect.addEventListener('change', () => {
        populateVatOptions(vatTypeSelect.value);
        calculatePrices();
    });

    vatSelect.addEventListener('change', calculatePrices);
    costPriceInclusiveInput.addEventListener('input', () => {
        if (getCostPriceType() === 'inclusive') calculatePrices();
    });
    costPriceExclusiveInput.addEventListener('input', () => {
        if (getCostPriceType() === 'exclusive') calculatePrices();
    });
    profitMarginInput.addEventListener('input', calculatePrices);
    discountTypeSelect.addEventListener('change', () => {
        if (discountTypeSelect.value === 'percentage') {
            discountValueInput.placeholder = 'Enter discount %';
            discountValueInput.min = 0;
            discountValueInput.max = 100;
        } else {
            discountValueInput.placeholder = 'Enter discount amount';
            discountValueInput.min = 0;
            discountValueInput.removeAttribute('max');
        }
        calculatePrices();
    });
    discountValueInput.addEventListener('input', calculatePrices);

    costPriceTypeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            const type = getCostPriceType();
            if (type === 'inclusive') {
                costPriceInclusiveInput.disabled = false;
                costPriceExclusiveInput.disabled = true;
                costPriceExclusiveInput.value = '';
            } else {
                costPriceInclusiveInput.disabled = true;
                costPriceExclusiveInput.disabled = false;
                costPriceInclusiveInput.value = '';
            }
            calculatePrices();
        });
    });

    function getVatPercent() {
        const selected = vatSelect.options[vatSelect.selectedIndex];
        if (!selected || !selected.value) return 0;
        const percent = selected.getAttribute('data-vat-percent');
        return percent ? parseFloat(percent) : 0;
    }

    function getCostPriceType() {
        for (const r of costPriceTypeRadios) {
            if (r.checked) return r.value;
        }
        return 'inclusive';
    }

    function calculatePrices() {
        const vatPercent = getVatPercent();
        const costPriceType = getCostPriceType();
        let costInclusive = parseFloat(costPriceInclusiveInput.value) || 0;
        let costExclusive = parseFloat(costPriceExclusiveInput.value) || 0;
        const profitMargin = parseFloat(profitMarginInput.value) || 0;
        const discountType = discountTypeSelect.value || 'percentage';
        const discountValueRaw = parseFloat(discountValueInput.value) || 0;

        if (costPriceType === 'inclusive') {
            costExclusive = costInclusive / (1 + vatPercent / 100);
            costPriceExclusiveInput.value = costExclusive.toFixed(2);
        } else {
            costInclusive = costExclusive * (1 + vatPercent / 100);
            costPriceInclusiveInput.value = costInclusive.toFixed(2);
        }

        const sellingPriceBeforeDiscount = costExclusive * (1 + profitMargin / 100);

        let discountAmount = 0;
        if (discountType === 'percentage') {
            discountAmount = sellingPriceBeforeDiscount * (discountValueRaw / 100);
        } else {
            discountAmount = discountValueRaw;
        }

        let finalSellingPrice = sellingPriceBeforeDiscount - discountAmount;
        if (finalSellingPrice < 0) finalSellingPrice = 0;

        sellingPriceInput.value = finalSellingPrice.toFixed(2);
    }

    (function init() {
        populateVatOptions(vatTypeSelect.value);
        const type = getCostPriceType();
        if (type === 'inclusive') {
            costPriceInclusiveInput.disabled = false;
            costPriceExclusiveInput.disabled = true;
        } else {
            costPriceInclusiveInput.disabled = true;
            costPriceExclusiveInput.disabled = false;
        }
        calculatePrices();
    })();
});
</script>

</x-layouts.sidebar>
