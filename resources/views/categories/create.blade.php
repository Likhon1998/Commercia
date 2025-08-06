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
        <div class="w-full max-w-md bg-white border border-gray-200 rounded-xl shadow-lg p-6">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Category Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        placeholder="Enter category name"
                        required
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="status"
                        name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm"
                        required
                    >
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('categories.index') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="bg-green-600 text-white px-5 py-2 rounded-md shadow hover:bg-green-700 transition"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sidebar>
