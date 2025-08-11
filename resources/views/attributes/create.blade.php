<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">➕ Create New Attribute</h2>
            <a href="{{ route('attributes.index') }}"
               class="inline-block px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white border border-gray-200 rounded shadow-sm p-6">
        <form method="POST" action="{{ route('attributes.store') }}" novalidate id="attributeForm" class="space-y-6">
            @csrf

            <!-- Attribute Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Attribute Name
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500
                        @error('name') border-red-500 @else border-gray-300 @enderror"
                    placeholder="Attribute Name"
                    required
                >
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attribute Values -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Attribute Values
                </label>

                <div id="value-fields" class="space-y-2">
                    @if(old('values'))
                        @foreach(old('values') as $value)
                            <input
                                type="text"
                                name="values[]"
                                value="{{ $value }}"
                                class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500
                                    @error('values.*') border-red-500 @else border-gray-300 @enderror"
                                placeholder="Value"
                                required
                            >
                        @endforeach
                    @else
                        <input
                            type="text"
                            name="values[]"
                            class="w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500 border-gray-300"
                            placeholder="Value"
                            required
                        >
                    @endif
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

                @error('values')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                @error('values.*')
                    <p class="text-xs text-red-600 mt-1">Each value must be valid.</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 rounded transition"
                >
                    💾 Save
                </button>

                <button
                    type="button"
                    onclick="document.getElementById('attributeForm').reset()"
                    class="flex-1 border border-green-600 text-green-600 hover:bg-green-50 text-sm font-semibold py-2 rounded transition"
                >
                    ❌ Cancel
                </button>
            </div>
        </form>
    </div>

    <script>
        function addValueField() {
            const container = document.getElementById('value-fields');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'values[]';
            input.placeholder = 'Value';
            input.required = true;
            input.className = 'w-full text-sm px-3 py-2 border rounded focus:ring-green-500 focus:border-green-500 border-gray-300';
            container.appendChild(input);
        }
    </script>
</x-layouts.sidebar>
