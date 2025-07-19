<!-- resources/views/components/layouts/sidebar.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @livewireStyles
</head>
<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-48 bg-green-600 text-white flex flex-col justify-between shadow-lg">
        <div>
            <div class="px-4 py-5 border-b border-green-500">
                <h2 class="text-lg font-bold truncate">{{ auth()->user()->name }}</h2>
                <p class="text-xs text-green-100 truncate">{{ auth()->user()->email }}</p>
            </div>

            <nav class="mt-4 px-3 space-y-1 text-sm">
                <a href="{{ route('dashboard') }}"
                   class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('dashboard') ? 'bg-green-700 font-semibold' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('roles.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('roles.*') ? 'bg-green-700 font-semibold' : '' }}">
                    👥 Roles
                </a>
                <a href="{{ route('permissions.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('permissions.*') ? 'bg-green-700 font-semibold' : '' }}">
                    🛡️ Permissions
                </a>
                <a href="{{ route('users.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('users.*') ? 'bg-green-700 font-semibold' : '' }}">
                    👤 Users
                </a>
                <a href="{{ route('categories.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('categories.*') ? 'bg-green-700 font-semibold' : '' }}">
                    📂 Categories
                </a>
                <a href="{{ route('attributes.index') }}"
                class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('attributes.*') ? 'bg-green-700 font-semibold' : '' }}">
                    🏷️ Attributes
                </a>
                <a href="{{ route('products.index') }}"
                   class="block px-3 py-2 rounded-md hover:bg-green-700 transition {{ request()->routeIs('products.*') ? 'bg-green-700 font-semibold' : '' }}">
                    🛍️ Products
                </a>
            </nav>
        </div>

        <!-- Logout -->
        <div class="px-4 py-4 border-t border-green-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-3 py-2 text-red-100 hover:bg-red-500 hover:text-white rounded-md transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-y-auto space-y-6">

        {{-- Header slot --}}
        @isset($header)
            <div class="bg-white px-6 py-4 rounded shadow">
                {{ $header }}
            </div>
        @endisset

        {{-- Main page content --}}
        {{ $slot }}

    </main>
</div>

@livewireScripts
</body>
</html>
