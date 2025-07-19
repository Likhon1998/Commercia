<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">➕ Add Category</h2>
            <a href="{{ route('categories.index') }}"
               class="text-sm text-gray-600 hover:text-indigo-600 transition underline">
               ← Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="flex items-center justify-center min-h-[70vh] px-4">
        <div class="w-full max-w-md bg-white rounded shadow p-6 border border-gray-200">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block font-semibold text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-300"
                           placeholder="Enter category name" required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="parent_id" class="block font-semibold text-gray-700 mb-1">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        <option value="">-- None --</option>
                        @foreach ($categories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('categories.index') }}"
                       class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 shadow transition">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sidebar>
