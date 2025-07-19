<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">➕ Create Attribute</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 p-6 bg-white shadow rounded">
        <form method="POST" action="{{ route('attributes.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Attribute Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Save
            </button>
        </form>
    </div>
</x-layouts.sidebar>
