<x-layouts.sidebar>
    <div class="flex items-center justify-center min-h-[80vh] px-4">
        <div class="w-full max-w-xl bg-white rounded-xl shadow-lg p-8 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-indigo-700">✏️ Edit User</h2>
                <a href="{{ route('users.index') }}"
                   class="text-sm text-gray-600 hover:text-indigo-600 transition underline">
                    ← Back to Users
                </a>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                    @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                    @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Password <small class="text-gray-500">(Leave blank to keep current password)</small>
                    </label>
                    <input type="password" name="password" id="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                    @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        Confirm Password
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                </div>

                <div>
                    <p class="block text-sm font-semibold text-gray-700 mb-2">Assign Roles</p>
                    <div class="grid grid-cols-2 gap-3 max-h-52 overflow-y-auto border p-3 rounded-md bg-gray-50">
                        @foreach($roles as $role)
                            <label class="inline-flex items-center text-sm text-gray-700 space-x-2">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->name }}"
                                    class="accent-indigo-600 rounded"
                                    {{ (in_array($role->name, old('roles', $user->roles->pluck('name')->toArray()))) ? 'checked' : '' }}
                                >
                                <span>{{ ucwords(str_replace('_', ' ', $role->name)) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('users.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-md border transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2 rounded-md shadow transition">
                        ✅ Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sidebar>
