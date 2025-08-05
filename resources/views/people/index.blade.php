<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-indigo-800">👥 People Management</h2>
            <a href="{{ route('people.create') }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold px-3 py-1.5 rounded">
                ➕ Add Person
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 p-4 bg-white shadow-md rounded-md text-sm">

        {{-- Header Bar --}}
        <form method="GET" action="{{ route('people.index') }}" class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <div class="flex items-center gap-2">
                <label for="perPage">Show</label>
                <select id="perPage" name="perPage" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                    @foreach ([10,25,50,100] as $size)
                        <option value="{{ $size }}" {{ request('perPage', 10) == $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
                <span>entries</span>
            </div>

            <div>
                <input
                    type="text"
                    name="search"
                    placeholder="🔍 Search..."
                    value="{{ request('search') }}"
                    class="border rounded px-3 py-1 text-sm w-48"
                    onkeydown="if(event.key === 'Enter'){ this.form.submit(); }"
                />
            </div>
        </form>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="mb-3 text-green-800 bg-green-100 border border-green-300 px-4 py-2 rounded text-xs">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        @if ($people->count())
            <div class="overflow-x-auto border border-gray-200 rounded">
                <table class="min-w-full text-xs text-left table-auto divide-y divide-gray-200">
                    <thead class="bg-indigo-100 text-indigo-800">
                        <tr>
                            <th class="px-3 py-2 w-6">SI</th>
                            <th class="px-3 py-2 w-36">Name</th>
                            <th class="px-3 py-2 w-28">Types</th>
                            <th class="px-3 py-2 w-24">Phone</th>
                            <th class="px-3 py-2 w-40">Email</th>
                            <th class="px-3 py-2 w-32">BIN</th>
                            <th class="px-3 py-2 w-24">City</th>
                            <th class="px-3 py-2 w-24">Country</th>
                            <th class="px-3 py-2 w-36">Address</th>
                            <th class="px-3 py-2 w-20">Status</th>
                            <th class="px-3 py-2 w-28 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($people as $index => $person)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $people->firstItem() + $index }}</td>
                                <td class="px-3 py-2 font-medium truncate">{{ $person->name }}</td>
                                <td class="px-3 py-2">
                                    @foreach (json_decode($person->person_type ?? '[]') as $type)
                                        <span class="inline-block px-2 py-0.5 mb-1 rounded-full text-[10px] font-medium text-white
                                            {{ $type === 'employee' ? 'bg-blue-500' : ($type === 'customer' ? 'bg-green-500' : ($type === 'supplier' ? 'bg-yellow-500' : 'bg-gray-500')) }} ">
                                            {{ ucfirst($type) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-3 py-2">{{ $person->phone ?? '—' }}</td>
                                <td class="px-3 py-2 truncate">{{ $person->email ?? '—' }}</td>
                                <td class="px-3 py-2">{{ $person->bin_number ?? '—' }}</td>
                                <td class="px-3 py-2">{{ $person->city ?? '—' }}</td>
                                <td class="px-3 py-2">{{ $person->country ?? '—' }}</td>
                                <td class="px-3 py-2 truncate">{{ $person->address ?? '—' }}</td>
                                <td class="px-3 py-2">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold
                                        {{ $person->status ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-700' }}">
                                        {{ $person->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('people.edit', $person) }}"
                                           class="px-2 py-1 text-xs text-blue-700 border border-blue-300 rounded hover:bg-blue-50">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('people.destroy', $person) }}" method="POST"
                                              onsubmit="return confirm('Are you sure to delete {{ $person->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-2 py-1 text-xs text-red-700 border border-red-300 rounded hover:bg-red-50">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $people->appends(request()->query())->links() }}
            </div>

        @else
            <div class="text-center py-6 text-gray-500 italic">
                No people found.
            </div>
        @endif
    </div>
</x-layouts.sidebar>
