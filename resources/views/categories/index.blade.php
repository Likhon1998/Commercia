<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">📂 Categories</h2>
            <a href="{{ route('categories.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow transition">
               + Add Category
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if($categories->isEmpty())
            <p class="text-center text-gray-500">No categories found.</p>
        @else
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                    <tr>
                        <th class="px-6 py-3">Serial</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Parent</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($categories as $index => $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-600">{{ $categories->firstItem() + $index }}</td>
                            <td class="px-6 py-3">{{ $category->name }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $category->parent?->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="inline-block text-white bg-blue-600 px-3 py-1 rounded shadow hover:bg-blue-700 text-xs transition">
                                   ✏️ Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-block text-white bg-red-600 px-3 py-1 rounded shadow hover:bg-red-700 text-xs transition">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-layouts.sidebar>
