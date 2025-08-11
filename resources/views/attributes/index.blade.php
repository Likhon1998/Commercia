<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">🧱 Product Attributes</h2>
            <a href="{{ route('attributes.create') }}"
               class="bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-400">
                ➕ Add Attribute
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white shadow-md rounded-md">
        <!-- Table -->
        @if ($attributes->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-md">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Attribute Name</th>
                            <th class="px-4 py-3 text-left">Values</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($attributes as $attribute)
                            <tr class="hover:bg-gray-50">
                                <!-- Attribute Name -->
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $attribute->name }}
                                </td>

                                <!-- Values -->
                                <td class="px-4 py-3">
                                    @if ($attribute->values->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($attribute->values as $val)
                                                <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded">
                                                    {{ $val->value }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="italic text-gray-400 text-xs">No values</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('attributes.edit', $attribute) }}"
                                       class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('attributes.destroy', $attribute) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete the attribute &quot;{{ $attribute->name }}&quot;?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium text-sm">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-gray-600 italic">No attributes found.</p>
        @endif
    </div>
</x-layouts.sidebar>
