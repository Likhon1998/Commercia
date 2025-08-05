<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-indigo-800 border-b pb-2">✏️ Edit Person</h2>
    </x-slot>

    @php
        // Ensure person_type is an array (decode if JSON string)
        $selectedTypes = old('person_type') ?? (is_array($person->person_type) ? $person->person_type : json_decode($person->person_type, true) ?? []);
    @endphp

    <div
        class="max-w-5xl mx-auto mt-6 bg-white p-4 rounded-md shadow border border-indigo-100 text-sm"
        x-data="{
            selectedTypes: {{ json_encode($selectedTypes) }},
            isEmployee() {
                return this.selectedTypes.includes('employee');
            }
        }"
    >
        <form action="{{ route('people.update', $person) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Personal Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $person->name) }}"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $person->phone) }}"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $person->email) }}"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">BIN Number</label>
                    <input type="text" name="bin_number" value="{{ old('bin_number', $person->bin_number) }}"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $person->city) }}"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Country</label>
                    <input type="text" name="country" value="{{ old('country', $person->country) }}"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <textarea name="address" rows="2"
                        class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">{{ old('address', $person->address) }}</textarea>
                </div>
            </div>

            {{-- Person Type --}}
            <div>
                <label class="block font-medium text-gray-700 mb-2">🧾 Person Type</label>
                <div class="flex flex-wrap gap-4">
                    @foreach (['customer', 'supplier', 'employee', 'other'] as $type)
                        <label class="inline-flex items-center text-gray-800 text-sm">
                            <input
                                type="checkbox"
                                name="person_type[]"
                                value="{{ $type }}"
                                x-model="selectedTypes"
                                class="form-checkbox h-4 w-4 text-indigo-600 rounded border-gray-300"
                                {{ in_array($type, $selectedTypes) ? 'checked' : '' }}>
                            <span class="ml-2 capitalize">{{ $type }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- System Access (only visible if employee is selected) --}}
            <div x-show="isEmployee()" x-transition>
                <label class="block text-sm font-semibold text-indigo-700 mb-3">💼 System Access (for employee)</label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Login Email</label>
                        <input type="email" name="user_email"
                            value="{{ old('user_email', $user->email ?? '') }}"
                            class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">New Password</label>
                        <input type="password" name="password" autocomplete="new-password"
                            placeholder="Leave blank to keep current password"
                            class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" autocomplete="new-password"
                            placeholder="Leave blank to keep current password"
                            class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Assign Role</label>
                        <select name="role"
                            class="w-full px-2 py-1 border rounded border-gray-300 focus:ring-indigo-500">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $selectedRole) === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-between items-center border-t pt-4">
                <div class="space-x-3">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-1.5 rounded">
                        ✅ Update
                    </button>
                    <a href="{{ route('people.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-1.5 rounded">
                        ❌ Cancel
                    </a>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="status" value="1"
                        class="form-checkbox h-4 w-4 text-indigo-600"
                        {{ old('status', $person->status) ? 'checked' : '' }}>
                    <label class="text-gray-800 font-medium text-sm">Active</label>
                </div>
            </div>
        </form>
    </div>
</x-layouts.sidebar>
