<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">🔐 Manage Permissions</h2>
            <a href="{{ route('permissions.create') }}"
               class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-md transition shadow">
                + Add Permission
            </a>
        </div>
    </x-slot>

    <div class="py-10 px-4 max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-700 text-sm">
                Total Permissions: 
                <span class="ml-2 inline-block bg-indigo-100 text-indigo-800 font-semibold px-3 py-1 rounded-full select-none">
                    {{ $permissions->total() }}
                </span>
            </p>
            <div>
                {{ $permissions->links() }}
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
            @if($permissions->isEmpty())
                <div class="p-12 text-center text-gray-500">
                    <p class="text-lg font-light">No permissions found.</p>
                    <p class="text-sm mt-1">Click the button above to add your first permission.</p>
                </div>
            @else
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-700 text-sm">
                        <tr>
                            <th class="px-6 py-4 font-semibold tracking-wide">Serial</th>
                            <th class="px-6 py-4 font-semibold tracking-wide">Permission Name</th>
                            <th class="px-6 py-4 font-semibold text-right tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($permissions as $index => $permission)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $permissions->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                                    {{ $permission->name }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('permissions.edit', $permission) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 text-xs rounded-md shadow-sm transition">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this permission?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 text-xs rounded-md shadow-sm transition">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4 flex justify-end">
                    {{ $permissions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.sidebar>
