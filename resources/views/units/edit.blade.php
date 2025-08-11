<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Edit Unit</h2>
            <a href="{{ route('units.index') }}"
               class="inline-block px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="max-w-md mx-auto mt-6 bg-white p-6 rounded shadow border border-gray-200">
        <form method="POST" action="{{ route('units.update', $unit->id) }}" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $unit->name) }}"
                    placeholder="Kilogram"
                    class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @else border-gray-300 @enderror"
                    required
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="short_name" class="block text-sm font-medium text-gray-700 mb-1">Short Name</label>
                <input
                    type="text"
                    name="short_name"
                    id="short_name"
                    value="{{ old('short_name', $unit->short_name) }}"
                    placeholder="kg"
                    class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500 @error('short_name') border-red-500 @else border-gray-300 @enderror"
                    required
                >
                @error('short_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded text-sm font-semibold transition">
                    💾 Update Unit
                </button>

                <a href="{{ route('units.index') }}" class="flex-1 border border-red-600 text-red-600 hover:bg-red-50 py-2 rounded text-sm font-semibold text-center transition">
                    ❌ Cancel
                </a>
            </div>
        </form>
    </div>
</x-layouts.sidebar>
