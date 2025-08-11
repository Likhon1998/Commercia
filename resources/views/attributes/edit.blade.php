<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Edit Attribute</h2>
            <a href="{{ route('attributes.index') }}"
               class="inline-block px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white border border-gray-200 rounded shadow-sm p-6">
        <form method="POST" action="{{ route('attributes.update', $attribute->id) }}" novalidate id="attributeForm" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Attribute Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Attribute Name
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $attribute->name) }}"
                    class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500
                        @error('name') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Attribute Name"
                    required
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Existing Attribute Values -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Existing Values <span class="text-gray-500 text-xs">(Clear input to delete)</span>
                </label>

                <div id="existing-value-fields" class="space-y-2">
                    @foreach ($attribute->values as $value)
                        <input
                            type="text"
                            name="values_existing[{{ $value->id }}]"
                            value="{{ old('values_existing.' . $value->id, $value->value) }}"
                            class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500
                                @error('values_existing.*') border-red-500 @else border-gray-300 @enderror"
                            placeholder="Value"
                        >
                    @endforeach
                </div>

                @error('values_existing.*')
                    <p class="text-xs text-red-600 mt-1">Please enter valid existing values or leave blank to delete.</p>
                @enderror
            </div>

            <!-- Add New Attribute Values -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Add New Values
                </label>

                <div id="new-value-fields" class="space-y-2">
                    <input
                        type="text"
                        name="values_new[]"
                        class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500 border-gray-300"
                        placeholder="Value"
                    >
                </div>

                <button
                    type="button"
                    onclick="addValueField()"
                    class="mt-2 inline-flex items-center text-sm text-green-600 hover:text-green-800 font-semibold focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add More
                </button>

                @error('values_new.*')
                    <p class="text-xs text-red-600 mt-1">Please enter valid new values.</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 rounded transition"
                >
                    💾 Save Changes
                </button>

                <a href="{{ route('attributes.index') }}"
                   class="flex-1 border border-red-600 text-red-600 hover:bg-red-50 text-sm font-semibold py-2 rounded transition text-center"
                >
                    ❌ Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        function addValueField() {
            const container = document.getElementById('new-value-fields');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'values_new[]';
            input.placeholder = 'Value';
            input.className = 'w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500 border-gray-300';
            container.appendChild(input);
        }
    </script>
</x-layouts.sidebar>
