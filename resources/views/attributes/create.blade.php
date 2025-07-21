<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6">➕ Create New Product Attribute</h2>
    </x-slot>

    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-lg p-8 border border-gray-200">
        <form method="POST" action="{{ route('attributes.store') }}" novalidate>
            @csrf

            <!-- Attribute Name -->
            <div class="mb-6">
                <label for="name" class="block text-lg font-semibold text-gray-700 mb-2">
                    Attribute Name
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none
                        @error('name') border-red-500 @else border-gray-300 @enderror"
                    placeholder="e.g. Color"
                    required
                    autofocus
                >
                @error('name')
                    <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Attribute Values -->
            <div class="mb-6">
                <label class="block text-lg font-semibold text-gray-700 mb-3">Attribute Values</label>

                <div id="value-fields" class="space-y-3">
                    @if(old('values'))
                        @foreach(old('values') as $value)
                            <input
                                type="text"
                                name="values[]"
                                value="{{ $value }}"
                                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none
                                    @error('values.*') border-red-500 @else border-gray-300 @enderror"
                                placeholder="e.g. Red"
                                required
                            >
                        @endforeach
                    @else
                        <input
                            type="text"
                            name="values[]"
                            class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300"
                            placeholder="e.g. Red"
                            required
                        >
                    @endif
                </div>

                <button
                    type="button"
                    onclick="addValueField()"
                    class="mt-4 inline-flex items-center space-x-2 text-blue-600 font-semibold hover:text-blue-800 focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add More Values</span>
                </button>

                @error('values')
                    <p class="text-red-600 mt-2 text-sm">{{ $message }}</p>
                @enderror
                @error('values.*')
                    <p class="text-red-600 mt-2 text-sm">Each value must be valid and non-empty.</p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg shadow-md transition-colors duration-300"
            >
                Save Attribute
            </button>
        </form>
    </div>

    <script>
        function addValueField() {
            const container = document.getElementById('value-fields');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'values[]';
            input.placeholder = 'e.g. Blue';
            input.required = true;
            input.className = 'w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none border-gray-300 mt-3';
            container.appendChild(input);
        }
    </script>
</x-layouts.sidebar>
