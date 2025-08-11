<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">Units of Measurement</h2>
            <a href="{{ route('units.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                + Add Unit
            </a>
        </div>
    </x-slot>

    <div class="mt-6 max-w-4xl mx-auto bg-white p-6 rounded shadow border border-gray-200">
        @if(session('success'))
            <p class="mb-4 text-green-600 font-semibold">{{ session('success') }}</p>
        @endif

        @if($units->count())
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Short Name</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $unit->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $unit->short_name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                                <a href="{{ route('units.edit', $unit->id) }}" class="text-blue-600 hover:underline">Edit</a>

                                <form method="POST" action="{{ route('units.destroy', $unit->id) }}" class="inline-block" onsubmit="return confirm('Delete this unit?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600 italic">No units found.</p>
        @endif
    </div>
</x-layouts.sidebar>
