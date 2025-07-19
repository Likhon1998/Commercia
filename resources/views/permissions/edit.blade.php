<x-layouts.sidebar>
  <div class="max-w-2xl mx-auto mt-16">
    <div class="bg-white shadow-lg rounded-lg p-8">
      <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Edit Permission</h2>
        <p class="text-gray-500 text-sm">Update the permission name below and click update.</p>
      </div>

      <form action="{{ route('permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Permission Name</label>
          <input type="text" name="name" id="name" value="{{ $permission->name }}"
                 class="w-full border border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-100 rounded-lg p-3 text-sm shadow-sm"
                 placeholder="Enter permission name">
          @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end">
          <a href="{{ route('permissions.index') }}"
             class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded mr-2">
            Cancel
          </a>
          <button type="submit"
                  class="bg-green-600 hover:bg-green-700 text-white text-sm px-6 py-2 rounded shadow-sm">
            ✅ Update
          </button>
        </div>
      </form>
    </div>
  </div>
</x-layouts.sidebar>
