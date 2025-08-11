<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">🧾 Individual VAT List</h2>
            <a href="{{ route('vat.create') }}"
               class="bg-green-600 text-white text-sm px-4 py-2 rounded-md hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-400">
                ➕ Add VAT
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 p-6 bg-white shadow-md rounded-md space-y-6">

        <!-- ✅ Success Alert -->
        @if(session('success'))
            <div class="px-4 py-3 bg-green-100 text-green-800 rounded border border-green-300 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- ✅ Search Input -->
        <form method="GET" action="{{ route('vat.index') }}">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="🔍 Search by name or VAT number..."
                   class="w-full sm:w-1/3 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        </form>

        <!-- ✅ VAT Table -->
        @if($vats->count())
            <div class="overflow-x-auto border border-gray-200 rounded-md">
                <table class="min-w-full text-sm text-gray-700 divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-xs text-gray-600 uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">VAT Number</th>
                            <th class="px-4 py-3 text-left">Percentage (%)</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($vats as $vat)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $vat->name }}</td>
                                <td class="px-4 py-3">{{ $vat->vat_number }}</td>
                                <td class="px-4 py-3">{{ number_format($vat->percentage, 2) }}</td>
                                <td class="px-4 py-3 capitalize">{{ $vat->status }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('vat.edit', $vat) }}"
                                       class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('vat.destroy', $vat) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete the VAT &quot;{{ $vat->name }}&quot;?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium text-sm">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ✅ Pagination -->
            <div class="mt-4 text-right">
                {{ $vats->withQueryString()->links() }}
            </div>
        @else
            <p class="text-sm text-gray-600 italic">No VAT records found.</p>
        @endif
    </div>
</x-layouts.sidebar>
