<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">📂 Categories</h2>
            <a href="{{ route('categories.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow">
               ➕ Add Category
            </a>
        </div>
    </x-slot>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Category Name</th>
                    <th class="py-3 px-6 text-left">Parent Category</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Created At</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left">{{ $category->name }}</td>
                        <td class="py-3 px-6 text-left">
                            {{ $category->parent ? $category->parent->name : '—' }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            @if($category->status)
                                <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs">Active</span>
                            @else
                                <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            {{ $category->created_at->format('d M, Y') }}
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                    ✏️
                                </a>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-500">
                            No categories found.  
                            <a href="{{ route('categories.create') }}" class="text-indigo-600 underline">Add one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.sidebar>
