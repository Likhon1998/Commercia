<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-indigo-800">🏪 Manage Outlets</h2>
            <a href="{{ route('outlets.create') }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold px-3 py-1.5 rounded">
                ➕ Add New Outlet
            </a>
        </div>
    </x-slot>

    <div class="mt-4 bg-white rounded shadow p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs text-left border border-gray-200 rounded">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-3 py-2 border">Serial</th>
                        <th class="px-3 py-2 border">Name</th>
                        <th class="px-3 py-2 border">Phone</th>
                        <th class="px-3 py-2 border">Email</th>
                        <th class="px-3 py-2 border">Address</th>
                        <th class="px-3 py-2 border">Status</th>
                        <th class="px-3 py-2 border">Default</th>
                        <th class="px-3 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($outlets as $index => $outlet)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-3 py-2 border">{{ $outlet->name }}</td>
                            <td class="px-3 py-2 border">{{ $outlet->phone }}</td>
                            <td class="px-3 py-2 border">{{ $outlet->email }}</td>
                            <td class="px-3 py-2 border">{{ $outlet->address }}</td>
                            <td class="px-3 py-2 border">
                                <span class="px-2 py-0.5 text-white text-[10px] rounded {{ $outlet->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ ucfirst($outlet->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 border text-center">
                                @if($outlet->default)
                                    <span class="text-green-600 font-bold">✔</span>
                                @else
                                    <span class="text-red-500 font-bold">✘</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 border flex space-x-2">
                                <a href="{{ route('outlets.edit', $outlet->id) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('outlets.destroy', $outlet->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this outlet?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-3 py-3 text-center text-gray-500">
                                No outlets found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.sidebar>
