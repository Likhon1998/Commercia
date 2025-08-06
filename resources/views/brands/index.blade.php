<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-indigo-800">🏷️ Brand List</h2>
            <a href="{{ route('brands.create') }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold px-3 py-1.5 rounded">
                ➕ Add New Brand
            </a>
        </div>
    </x-slot>

    <div class="mt-4 bg-white rounded shadow p-4">
        <table class="min-w-full text-xs border">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-3 py-2 border">#</th>
                    <th class="px-3 py-2 border">Name</th>
                    <th class="px-3 py-2 border">Image</th>
                    <th class="px-3 py-2 border">Category</th>
                    <th class="px-3 py-2 border">Status</th>
                    <th class="px-3 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $index => $brand)
                    <tr>
                        <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-3 py-2 border">{{ $brand->name }}</td>
                        <td class="px-3 py-2 border">
                            @if ($brand->image)
                                <img src="{{ asset('storage/' . $brand->image) }}" class="h-8 w-8 rounded-full" />
                            @endif
                        </td>
                        <td class="px-3 py-2 border">{{ $brand->category->name ?? '-' }}</td>
                        <td class="px-3 py-2 border">
                            <span class="px-2 py-1 rounded text-white text-xs {{ $brand->status === 'active' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($brand->status) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 border">
                            <a href="{{ route('brands.edit', $brand) }}"
                               class="text-indigo-600 hover:text-indigo-800 text-xs">✏️ Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.sidebar>
