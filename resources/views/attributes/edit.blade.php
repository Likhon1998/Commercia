<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">✏️ Edit Attribute</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 p-6 bg-white shadow rounded">
        <form method="POST" action="{{ route('attributes.update', $attribute) }}">
            @csrf
            @method('PUT')

            <!-- Attribute Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Attribute Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $attribute->name) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Existing Values -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Values</label>
                <div id="value-fields" class="space-y-2">
                    @foreach ($attribute->values as $value)
                        <div class="flex items-center gap-2">
                            <input type="text" name="values_existing[{{ $value->id }}]" value="{{ $value->value }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm" required>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-sm">✖</button>
                        </div>
                    @endforeach
                </div>

                <!-- New Values Section -->
                <button type="button" onclick="addNewValueField()"
                        class="mt-2 text-blue-600 hover:underline text-sm">
                    ➕ Add New Value
                </button>
            </div>

            <!-- Submission -->
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>

    <!-- JS for adding new fields -->
    <script>
        function addNewValueField() {
            const container = document.getElementById('value-fields');
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center gap-2 mt-2';
            wrapper.innerHTML = `
                <input type="text" name="values_new[]" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="New value" required>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-sm">✖</button>
            `;
            container.appendChild(wrapper);
        }
    </script>
</x-layouts.sidebar>
