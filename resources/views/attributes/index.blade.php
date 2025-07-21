<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">🧱 Product Attributes</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 p-6 bg-white shadow rounded">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <h3 class="text-lg font-semibold text-gray-800">All Attributes</h3>
            <a href="{{ route('attributes.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
               aria-label="Add new product attribute">
                ➕ Add Attribute
            </a>
        </div>

        @if ($attributes->count())
            <ul class="divide-y divide-gray-200">
                @foreach ($attributes as $attribute)
                    <li class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $attribute->name }}</h4>
                            <div class="mt-1 text-sm text-gray-600 flex flex-wrap gap-2">
                                @if ($attribute->values->count())
                                    @foreach ($attribute->values as $val)
                                        <span
                                            class="inline-block bg-gray-200 px-2 py-1 rounded text-sm select-none">
                                            {{ $val->value }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 italic">No values added</span>
                                @endif
                            </div>
                        </div>
                        <div class="space-x-3 flex-shrink-0">
                            <a href="{{ route('attributes.edit', $attribute) }}"
                               class="text-blue-600 hover:underline focus:outline-none focus:ring-1 focus:ring-blue-500"
                               aria-label="Edit attribute {{ $attribute->name }}">
                                Edit
                            </a>
                            <form action="{{ route('attributes.destroy', $attribute) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete the attribute &quot;{{ $attribute->name }}&quot;?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline focus:outline-none focus:ring-1 focus:ring-red-500"
                                        aria-label="Delete attribute {{ $attribute->name }}">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600 italic">No attributes found.</p>
        @endif
    </div>
</x-layouts.sidebar>
