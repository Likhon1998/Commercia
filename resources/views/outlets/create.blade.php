<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 border-b pb-2">🏢 Add Outlet</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-4 rounded-md shadow text-xs">
        <form action="{{ route('outlets.store') }}" method="POST" class="space-y-4">
            @csrf

            <section>
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Outlet Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label for="name" class="block mb-1 font-medium text-gray-700">Outlet Name <span class="text-red-600">*</span></label>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs">
                        @error('name')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block mb-1 font-medium text-gray-700">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs">
                        @error('phone')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs">
                        @error('email')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block mb-1 font-medium text-gray-700">Address</label>
                        <textarea id="address" name="address" rows="2"
                                  class="block w-full rounded border border-gray-300 px-1.5 py-0.5 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 resize-none text-xs">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Status and Default --}}
            <section class="flex justify-between items-center pt-4 border-t space-x-3">
                <div class="flex space-x-2">
                    <button type="submit"
                            class="rounded bg-blue-600 px-4 py-1 text-white font-semibold text-xs hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        Save Outlet
                    </button>
                    <a href="{{ route('outlets.index') }}"
                       class="rounded bg-gray-300 px-4 py-1 text-gray-800 font-semibold text-xs hover:bg-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400">
                        Cancel
                    </a>
                </div>

                <div class="flex space-x-4 items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="status" value="active"
                               {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                               class="form-checkbox h-3.5 w-3.5 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-xs text-gray-700">Active</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="default" value="1"
                               {{ old('default') ? 'checked' : '' }}
                               class="form-checkbox h-3.5 w-3.5 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="ml-2 text-xs text-gray-700">Make Default</span>
                    </label>
                </div>
            </section>
        </form>
    </div>
</x-layouts.sidebar>
