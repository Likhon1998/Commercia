<x-layouts.sidebar>
    <div class="py-10 px-6 max-w-5xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                Manage Roles
                <span class="text-sm bg-green-600 text-white px-3 py-1 rounded-full font-semibold shadow-lg">
                    Total: {{ $roles->total() }}
                </span>
            </h1>
            <a href="{{ route('roles.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded-md shadow transition">
                + Add Role
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Roles List --}}
        <table class="w-full table-auto bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-700 w-12">Serial</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-700">Role Name</th>
                    <th class="text-left px-6 py-3 text-sm font-semibold text-gray-700 max-w-xl">Permissions</th>
                    <th class="text-right px-6 py-3 text-sm font-semibold text-gray-700 w-40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $index => $role)
                    <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-600">{{ $roles->firstItem() + $index }}</td>
                        <td class="px-6 py-4 text-gray-900 font-normal">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm max-w-xl whitespace-normal">
                            {{ $role->permissions->pluck('name')->join(', ') ?: 'None' }}
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-3">
                            <a href="{{ route('roles.edit', $role) }}"
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-semibold shadow-sm transition">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-semibold shadow-sm transition">
                                    🗑️ Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-10">
                            No roles found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Pagination --}}
        <div class="mt-6">
            {{ $roles->links() }}
        </div>
        
    </div>
</x-layouts.sidebar>
