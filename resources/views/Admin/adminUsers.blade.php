
@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Quản lý người dùng</h1>
    <form method="GET" action="" class="flex flex-wrap items-end gap-4 overflow-x-auto mb-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
            <input type="text" name="name" id="name" value="{{ request('name') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px] px-3 py-2 whitespace-nowrap" placeholder="Tên người dùng">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="text" name="email" id="email" value="{{ request('email') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 min-w-[140px] px-3 py-2 whitespace-nowrap" placeholder="Email">
        </div>
        <div class="flex items-end h-full gap-2">
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow min-w-[90px] justify-center">Lọc</button>
            <a href="{{ route(request()->route()->getName()) }}" class="inline-flex items-center px-6 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition shadow min-w-[90px] justify-center">Reset</a>
            <a href="{{ route('admin.users.newUser') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tạo mới user
            </a>
        </div>
    </form>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        @php
            $sort = request('sort', '');
            $direction = request('direction', 'asc');
            function sortUrlUser($column) {
                $currentSort = request('sort', '');
                $currentDirection = request('direction', 'asc');
                $newDirection = ($currentSort === $column && $currentDirection === 'asc') ? 'desc' : 'asc';
                return request()->fullUrlWithQuery(['sort' => $column, 'direction' => $newDirection]);
            }
            function sortIconUser($column) {
                $currentSort = request('sort', '');
                $currentDirection = request('direction', 'asc');
                if ($currentSort === $column) {
                    return $currentDirection === 'asc' ? '▲' : '▼';
                }
                return '';
            }
        @endphp
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlUser('id') }}" class="flex items-center gap-1">
                            ID <span class="text-xs">{{ sortIconUser('id') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlUser('name') }}" class="flex items-center gap-1">
                            Tên <span class="text-xs">{{ sortIconUser('name') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlUser('email') }}" class="flex items-center gap-1">
                            Email <span class="text-xs">{{ sortIconUser('email') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlUser('created_at') }}" class="flex items-center gap-1">
                            Ngày tạo <span class="text-xs">{{ sortIconUser('created_at') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase cursor-pointer select-none">
                        <a href="{{ sortUrlUser('updated_at') }}" class="flex items-center gap-1">
                            Ngày cập nhật <span class="text-xs">{{ sortIconUser('updated_at') }}</span>
                        </a>
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-2 font-semibold whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <a href="{{ route('admin.users.updateUser', ['id' => $user->id]) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                            <a href="#" class="text-red-600 hover:underline" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">Xóa</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Không có người dùng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection
