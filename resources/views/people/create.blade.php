<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900 border-b pb-2">➕ Add Person</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white p-4 rounded-md shadow"
         x-data="{
            selectedTypes: @json(old('person_type', [])),
            isEmployee() { return this.selectedTypes.includes('employee'); }
         }"
    >
        <form action="{{ route('people.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            {{-- Personal Info --}}
            <section>
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                    <div>
                        <label for="name" class="block mb-1 font-medium text-gray-700">Name <span class="text-red-600">*</span></label>
                        <input id="name" name="name" type="text" required
                               value="{{ old('name') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('name')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block mb-1 font-medium text-gray-700">Phone</label>
                        <input id="phone" name="phone" type="text"
                               value="{{ old('phone') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('phone')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-1 font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('email')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bin_number" class="block mb-1 font-medium text-gray-700">Business Identification Number (BIN)</label>
                        <input id="bin_number" name="bin_number" type="text"
                               value="{{ old('bin_number') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('bin_number')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                      <div class="md:col-span-1">
                        <label for="country" class="block mb-1 font-medium text-gray-700">Country</label>
                        <input id="country" name="country" type="text"
                               value="{{ old('country') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('country')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block mb-1 font-medium text-gray-700">City</label>
                        <input id="city" name="city" type="text"
                               value="{{ old('city') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('city')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block mb-1 font-medium text-gray-700">Address</label>
                        <textarea id="address" name="address" rows="2"
                                  class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                         placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 resize-none text-xs"
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Person Type --}}
            <section>
                <p class="mb-2 font-medium text-gray-700 text-xs">Person Type <span class="text-red-600">*</span></p>
                <div class="flex flex-wrap gap-3 mb-5">
                    @foreach (['customer', 'supplier', 'employee', 'other'] as $type)
                        <label class="inline-flex items-center cursor-pointer text-gray-800 capitalize text-xs">
                            <input
                                type="checkbox"
                                name="person_type[]"
                                value="{{ $type }}"
                                x-model="selectedTypes"
                                class="form-checkbox h-3.5 w-3.5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                            >
                            <span class="ml-1.5 select-none">{{ $type }}</span>
                        </label>
                    @endforeach
                </div>
                @error('person_type')
                    <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                @enderror
            </section>

            {{-- Employee Access Section --}}
            <section
                x-show="isEmployee()"
                x-transition
                class="border-t pt-4"
            >
                <h3 class="text-sm font-semibold text-gray-800 mb-3">System Access (Employee Only)</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    <div>
                        <label for="user_email" class="block mb-1 font-medium text-gray-700">Login Email <span class="text-red-600">*</span></label>
                        <input id="user_email" name="user_email" type="email"
                               value="{{ old('user_email') }}"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('user_email')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block mb-1 font-medium text-gray-700">Password <span class="text-red-600">*</span></label>
                        <input id="password" name="password" type="password"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                        @error('password')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-1 font-medium text-gray-700">Confirm Password <span class="text-red-600">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="block w-full rounded border border-gray-300 px-1.5 py-0.5
                                      placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-xs"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <p class="font-medium text-gray-700 mb-2 text-xs">Assign Role <span class="text-red-600">*</span></p>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($roles as $role)
                                <label class="inline-flex items-center cursor-pointer text-gray-800 capitalize text-xs">
                                    <input
                                        type="radio"
                                        name="role"
                                        value="{{ $role->name }}"
                                        class="form-radio h-3.5 w-3.5 text-blue-600"
                                        {{ old('role') === $role->name ? 'checked' : '' }}
                                    >
                                    <span class="ml-1.5 select-none">{{ $role->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('role')
                            <p class="text-[10px] text-red-600 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Bottom row: Active checkbox right aligned, Submit and Cancel buttons left --}}
            <section class="flex justify-between items-center pt-4 border-t space-x-3">
                <div class="flex space-x-2">
                    <button type="submit"
                            class="rounded bg-blue-600 px-4 py-1 text-white font-semibold text-xs hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        Save Person
                    </button>
                    <a href="{{ route('people.index') }}"
                       class="rounded bg-gray-300 px-4 py-1 text-gray-800 font-semibold text-xs hover:bg-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400">
                        Cancel
                    </a>
                </div>

                <div class="flex items-center space-x-1">
                    <input id="status" name="status" type="checkbox" value="1"
                           {{ old('status', 1) ? 'checked' : '' }}
                           class="form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                    >
                    <label for="status" class="text-gray-800 font-medium select-none text-xs">Active</label>
                </div>
            </section>

        </form>
    </div>
</x-layouts.sidebar>
