<x-layouts.sidebar>
    <div class="flex items-center justify-center min-h-[80vh] px-4">
        <div class="w-full max-w-xl bg-white rounded-xl shadow-lg p-8 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-indigo-700">🔐 Add New Permission</h2>
                <a href="{{ route('permissions.index') }}"
                   class="text-sm text-gray-600 hover:text-indigo-600 transition underline">
                    ← Back to Permissions
                </a>
            </div>

            <form action="{{ route('permissions.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Permission Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none"
                           placeholder="e.g., edit-products" required>
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('permissions.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-md border transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white text-sm px-6 py-2 rounded-md shadow transition">
                        ✅ Create Permission
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sidebar>
