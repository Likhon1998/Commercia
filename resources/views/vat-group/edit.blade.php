<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">✏️ Edit VAT Group</h2>
            <a href="{{ route('vat-group.index') }}"
               class="text-indigo-600 hover:text-indigo-800 font-medium text-sm underline">
                ← Back to VAT Groups
            </a>
        </div>
    </x-slot>

    <div class="max-w-lg mx-auto mt-6 p-6 bg-white shadow-md rounded-md">
        <form action="{{ route('vat-group.update', $vatGroup) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-1">Group Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $vatGroup->name) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('name') border-red-500 @enderror" />
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', $vatGroup->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $vatGroup->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- VATs Multi-Select -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Select VATs</label>
                @if($vats->count())
                    <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3 bg-white">
                        @foreach($vats as $vat)
                            <div class="flex items-center mb-2">
                                <input type="checkbox" id="vat_{{ $vat->id }}" name="vat_ids[]" value="{{ $vat->id }}"
                                       class="mr-2"
                                       {{ (is_array(old('vat_ids', $selectedVatIds)) && in_array($vat->id, old('vat_ids', $selectedVatIds))) ? 'checked' : '' }} />
                                <label for="vat_{{ $vat->id }}" class="text-gray-800">
                                    {{ $vat->name }} ({{ number_format($vat->percentage, 2) }}%)
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600 italic">No active VATs available.</p>
                @endif
                @error('vat_ids')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-400">
                Update VAT Group
            </button>
        </form>
    </div>
</x-layouts.sidebar>
