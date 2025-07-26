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
            <div class="h-16 flex items-center justify-center border-b">
                <span class="font-bold text-xl text-blue-600">Admin Panel</span>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-blue-100 @if(request()->routeIs('admin.dashboard')) bg-blue-200 font-semibold @endif">Dashboard</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Quản lý sản phẩm</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Quản lý đơn hàng</a>
                <a href="#" class="block px-4 py-2 rounded hover:bg-blue-100">Quản lý người dùng</a>
                <a href="{{ route('logout') }}" class="block px-4 py-2 rounded hover:bg-red-100 text-red-600">Đăng xuất</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
