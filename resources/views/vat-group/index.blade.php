<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">🧩 VAT Groups</h2>
            <a href="{{ route('vat-group.create') }}"
               class="bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-400">
                ➕ Add VAT Group
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white shadow-md rounded-md">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 text-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- 🔍 Search Bar -->
        <div class="mb-4 flex justify-end">
            <form action="{{ route('vat-group.index') }}" method="GET">
                <input type="text" name="search" placeholder="Search groups..."
                       class="border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring focus:ring-green-200">
            </form>
        </div>

        @if($vatGroups->count())
            <div class="overflow-x-auto border rounded-md shadow-sm">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Group Name</th>
                            <th class="px-4 py-3 text-left">Included VATs</th>
                            <th class="px-4 py-3 text-left">Total %</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($vatGroups as $group)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $group->name }}</td>
                                <td class="px-4 py-3">
                                    @if($group->vats->count())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($group->vats as $vat)
                                                <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-0.5 rounded">
                                                    {{ $vat->name }} ({{ number_format($vat->percentage, 2) }}%)
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="italic text-gray-400 text-xs">No VATs assigned</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ number_format($group->totalPercentage(), 2) }}</td>
                                <td class="px-4 py-3">{{ ucfirst($group->status) }}</td>
                                <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('vat-group.edit', $group) }}"
                                       class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('vat-group.destroy', $group) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete VAT Group &quot;{{ $group->name }}&quot;?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                {{ $vatGroups->links() }}
            </div>
        @else
            <p class="text-sm text-gray-600 italic mt-4">No VAT groups found.</p>
        @endif
    </div>
</x-layouts.sidebar>
