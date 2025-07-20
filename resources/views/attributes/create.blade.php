<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">➕ Create Attribute</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 p-6 bg-white shadow rounded">
        <form method="POST" action="{{ route('attributes.store') }}">
            @csrf

            <!-- Attribute Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Attribute Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Attribute Values -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Values</label>
                <div id="value-fields" class="space-y-2">
                    <input type="text" name="values[]" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. Red" required>
                </div>
                <button type="button" onclick="addValueField()"
                        class="mt-2 text-blue-600 hover:underline text-sm">
                    ➕ Add More Values
                </button>
                @error('values') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Save
            </button>
        </form>
    </div>

    <!-- JavaScript to add value fields -->
    <script>
        function addValueField() {
            const container = document.getElementById('value-fields');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'values[]';
            input.className = 'w-full rounded-md border-gray-300 shadow-sm mt-2';
            input.placeholder = 'e.g. Blue';
            container.appendChild(input);
        }
    </script>
</x-layouts.sidebar>
