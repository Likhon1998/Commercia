<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-indigo-700">Add New Brand</h2>
    </x-slot>

    <div class="flex justify-center mt-8 px-4">
        <div class="w-full max-w-xl bg-gradient-to-br from-indigo-50 via-white to-indigo-50 rounded-lg shadow-lg p-6">
            
            <form action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Brand Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    >
                </div>

                {{-- Brand Image --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Brand Image</label>
                    <input
                        type="file"
                        name="image"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    >
                </div>

                {{-- Select Category --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                    <select
                        name="category_id"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    >
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <div class="flex gap-6">
                        <label class="flex items-center space-x-2">
                            <input
                                type="radio"
                                name="status"
                                value="active"
                                class="accent-indigo-600"
                                {{ old('status', 'active') === 'active' ? 'checked' : '' }}
                            >
                            <span class="text-gray-700 text-sm">Active</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input
                                type="radio"
                                name="status"
                                value="inactive"
                                class="accent-red-500"
                                {{ old('status') === 'inactive' ? 'checked' : '' }}
                            >
                            <span class="text-gray-700 text-sm">Inactive</span>
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex space-x-4">
                    <button
                        type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-md transition"
                    >
                        Save Brand
                    </button>

                    <a
                        href="{{ route('brands.index') }}"
                        class="flex-1 text-center bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 rounded-md transition cursor-pointer"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sidebar>
