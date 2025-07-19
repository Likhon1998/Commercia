<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">🧱 Product Attributes</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 p-6 bg-white shadow rounded">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">All Attributes</h3>
            <a href="{{ route('attributes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Add Attribute
            </a>
        </div>

        @if($attributes->count())
            <ul class="divide-y divide-gray-200">
                @foreach($attributes as $attribute)
                    <li class="py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $attribute->name }}</h4>
                                <div class="text-sm text-gray-600">
                                    @foreach ($attribute->values as $val)
                                        <span class="inline-block bg-gray-200 px-2 py-1 rounded text-sm mr-2">{{ $val->value }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="space-x-2">
                                <a href="{{ route('attributes.edit', $attribute) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('attributes.destroy', $attribute) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600">No attributes found.</p>
        @endif
    </div>
</x-layouts.sidebar>
