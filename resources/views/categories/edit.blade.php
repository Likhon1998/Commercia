<x-layouts.sidebar>
  <x-slot name="header">
    <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-5">
      <h1 class="text-lg font-semibold text-gray-900">Edit Category</h1>
      <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
    </div>
  </x-slot>

  <div class="max-w-sm mx-auto bg-white rounded-lg border border-gray-100 shadow-sm p-6">
    @if ($errors->any())
      <div class="mb-4 text-xs text-red-600 bg-red-50 border border-red-200 rounded px-3 py-2">
        <ul class="list-disc list-inside space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-4" novalidate>
      @csrf
      @method('PUT')

      {{-- Name --}}
      <div>
        <label for="name" class="block text-xs font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name', $category->name) }}"
          placeholder="e.g. Footwear"
          required
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400
                 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition"
          style="height: 34px;"
        >
        @error('name')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Parent Category --}}
      <div>
        <label for="parent_id" class="block text-xs font-medium text-gray-700 mb-1">Parent Category</label>
        <select
          id="parent_id"
          name="parent_id"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900
                 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition"
          style="height: 34px;"
        >
          <option value="" class="text-gray-400">— No Parent (Main Category) —</option>
          @foreach ($categories as $parent)
            <option
              value="{{ $parent->id }}"
              {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}
              @if ($parent->id === $category->id) disabled @endif
            >
              {{ $parent->name }}
            </option>
          @endforeach
        </select>
        @error('parent_id')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Status --}}
      <div>
        <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
        <select
          id="status"
          name="status"
          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-900
                 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition"
          style="height: 34px;"
        >
          <option value="active" {{ old('status', $category->status) === 'active' ? 'selected' : '' }}>Active</option>
          <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Submit --}}
      <button
        type="submit"
        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold rounded-md py-2 text-sm shadow-sm
               transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-red-400"
      >
        Update Category
      </button>
    </form>
  </div>
</x-layouts.sidebar>
