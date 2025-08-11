<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Edit VAT</h2>
            <a href="{{ route('vat.index') }}"
               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm underline">
                ← Back to VAT List
            </a>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6 p-6 bg-white shadow-md rounded-md">
        <form action="{{ route('vat.update', $vat) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-1">VAT Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $vat->name) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('name') border-red-500 @enderror" />
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- VAT Number -->
            <div class="mb-4">
                <label for="vat_number" class="block text-gray-700 font-medium mb-1">VAT Number</label>
                <input type="text" id="vat_number" name="vat_number" value="{{ old('vat_number', $vat->vat_number) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('vat_number') border-red-500 @enderror" />
                @error('vat_number')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Percentage -->
            <div class="mb-4">
                <label for="percentage" class="block text-gray-700 font-medium mb-1">Percentage (%)</label>
                <input type="number" step="0.01" min="0" max="100" id="percentage" name="percentage" value="{{ old('percentage', $vat->percentage) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('percentage') border-red-500 @enderror" />
                @error('percentage')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', $vat->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $vat->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
                Update VAT
            </button>
        </form>
    </div>
</x-layouts.sidebar>
