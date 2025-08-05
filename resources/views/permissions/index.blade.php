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

    <div class="py-10 px-4 max-w-5xl mx-auto" x-data="{ confirmingId: null }">
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
                                        <!-- Delete button -->
                                        <button @click.prevent="confirmingId = {{ $permission->id }}"
                                                class="bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-800 px-3 py-1.5 text-xs rounded-md shadow-sm transition flex items-center gap-1">
                                            🗑️ Delete
                                        </button>
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

        <!-- Confirmation Modal -->
        <div x-show="confirmingId"
             class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
             x-cloak>
            <div class="bg-white p-6 rounded-lg shadow-md max-w-sm w-full">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Delete Confirmation</h2>
                <p class="text-sm text-gray-600">Are you sure you want to delete this permission? This action cannot be undone.</p>

                <div class="mt-4 flex justify-end gap-2">
                    <button @click="confirmingId = null"
                            class="px-3 py-1 text-sm bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                        Cancel
                    </button>

                    <form :action="`/permissions/${confirmingId}`" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                            Confirm Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.sidebar>
