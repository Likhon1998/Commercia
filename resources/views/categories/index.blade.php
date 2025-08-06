<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">📂 All Categories</h2>
            <a href="{{ route('categories.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-md shadow">
                ➕ Add Category
            </a>
        </div>
    </x-slot>

    <div class="px-6 py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr class="text-left text-sm text-gray-600">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $key => $category)
                        <tr class="border-t text-sm text-gray-700 hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $key + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ $category->name }}</td>
                            <td class="px-4 py-3">
                                @if($category->status === 'active')
                                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this category?')"
                                            class="text-red-600 hover:text-red-800 text-sm font-semibold">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                                No categories found. <a href="{{ route('categories.create') }}" class="text-indigo-600 underline">Create one</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.sidebar>
