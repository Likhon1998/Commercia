<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

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
    <aside class="w-52 bg-green-600 text-white flex flex-col justify-between shadow-lg text-xs">
        <div>
            <div class="px-4 py-4 border-b border-green-500">
                <h2 class="text-sm font-bold truncate">{{ auth()->user()->name }}</h2>
                <p class="text-[10px] text-green-100 truncate">{{ auth()->user()->email }}</p>
            </div>

            <nav class="mt-4 px-2 space-y-1">
                <a href="{{ route('dashboard') }}"
                   class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('dashboard') ? 'bg-green-700 font-semibold' : '' }}"
                   title="Dashboard">
                    📊 Dashboard
                </a>

                <a href="{{ route('roles.index') }}"
                   class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('roles.*') ? 'bg-green-700 font-semibold' : '' }}"
                   title="Roles">
                    👥 Roles
                </a>

                <a href="{{ route('permissions.index') }}"
                   class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('permissions.*') ? 'bg-green-700 font-semibold' : '' }}"
                   title="Permissions">
                    🛡️ Permissions
                </a>

                <a href="{{ route('people.index') }}"
                   class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('people.*') ? 'bg-green-700 font-semibold' : '' }}"
                   title="People">
                    🙋 People
                </a>

                <a href="{{ route('users.index') }}"
                   class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('users.*') ? 'bg-green-700 font-semibold' : '' }}"
                   title="Users">
                    👤 Users
                </a>

                <!-- 🛠️ Product Management Dropdown -->
                <div x-data="{ open: {{ request()->is('brands*') || request()->is('outlets*') || request()->is('categories*') || request()->is('attributes*') || request()->is('products*') || request()->is('units*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-2 py-2 rounded-md hover:bg-green-700 transition focus:outline-none truncate"
                            :class="{ 'bg-green-700 font-semibold': open }"
                            title="Product Management">
                        <div class="flex items-center space-x-1">
                            <span>🛠️</span>
                            <span class="truncate">Product Management</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="h-3 w-3 transform transition-transform" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" class="ml-3 space-y-1" x-cloak>
                        <a href="{{ route('brands.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('brands.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Brands">
                            🏷️ Brands
                        </a>
                        <a href="{{ route('outlets.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('outlets.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Outlets">
                            🏪 Outlets
                        </a>
                        <a href="{{ route('categories.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('categories.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Categories">
                            📂 Categories
                        </a>
                        <a href="{{ route('attributes.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('attributes.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Attributes">
                            🧩 Attributes
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('products.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Products">
                            🛍️ Products
                        </a>
                        <a href="{{ route('units.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('units.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Units of Measurement">
                            📐 Units of Measurement
                        </a>
                    </div>
                </div>

                <!-- 💰 VAT Settings Dropdown -->
                <div x-data="{ open: {{ request()->is('vat*') || request()->is('vat-group*') ? 'true' : 'false' }} }" class="space-y-1 mt-1">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-2 py-2 rounded-md hover:bg-green-700 transition focus:outline-none truncate"
                            :class="{ 'bg-green-700 font-semibold': open }"
                            title="VAT Settings">
                        <div class="flex items-center space-x-1">
                            <span>💰</span>
                            <span class="truncate">VAT Settings</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="h-3 w-3 transform transition-transform" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" class="ml-3 space-y-1" x-cloak>
                        <a href="{{ route('vat.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('vat.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="Individual VATs">
                            🧾 Individual VATs
                        </a>
                        <a href="{{ route('vat-group.index') }}"
                           class="block px-2 py-2 rounded-md hover:bg-green-700 transition truncate {{ request()->routeIs('vat-group.*') ? 'bg-green-700 font-semibold' : '' }}"
                           title="VAT Groups">
                            🧮 VAT Groups
                        </a>
                    </div>
                </div>

            </nav>
        </div>

        <!-- Logout -->
        <div class="px-4 py-3 border-t border-green-500">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-2 py-2 text-red-100 hover:bg-red-500 hover:text-white rounded-md transition text-xs">
                    🚪 Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-4 overflow-y-auto space-y-4 text-sm">

        {{-- Header slot --}}
        @isset($header)
            <div class="bg-white px-4 py-3 rounded shadow">
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
