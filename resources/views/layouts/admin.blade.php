<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="h-16 flex flex-col items-center justify-center border-b">
                <span class="font-bold text-xl text-blue-600">Admin Panel</span>
                @auth('admin')
                    <span class="text-sm text-gray-600 mt-1">{{ Auth::guard('admin')->user()->name }}</span>
                @endauth
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                
               <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Trang chủ') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.products.view')" :active="request()->routeIs('admin.products.view')">
                    {{ __('Quản lý sản phẩm') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.orders.view')" :active="request()->routeIs('admin.orders.view')">
                    {{ __('Quản lý đơn hàng') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.view')" :active="request()->routeIs('admin.users.view')">
                    {{ __('Quản lý người dùng') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Về Trang web') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('admin.logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
