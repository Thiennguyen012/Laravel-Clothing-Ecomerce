@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 max-w-xl">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Cập nhật tài khoản người dùng</h1>
        <a href="{{ route('admin.users.view') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">← Quay lại</a>
    </div>
    @if(session('success'))
        <div id="modal-success" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                <div class="text-green-600 text-3xl mb-2">✔</div>
                <div class="text-lg font-semibold mb-2">{{ session('success') }}</div>
                <button onclick="document.getElementById('modal-success').style.display='none'" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Đóng</button>
            </div>
        </div>
    @endif
    @if(session('success_password'))
        <div id="modal-success-password" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                <div class="text-green-600 text-3xl mb-2">✔</div>
                <div class="text-lg font-semibold mb-2">{{ session('success_password') }}</div>
                <button onclick="document.getElementById('modal-success-password').style.display='none'" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Đóng</button>
            </div>
        </div>
    @endif
    <!-- Form cập nhật thông tin -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Cập nhật thông tin</h2>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required>
                @error('name')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required>
                @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow">Cập nhật</button>
            </div>
        </form>
    </div>
    <!-- Form cập nhật mật khẩu -->
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Đổi mật khẩu</h2>
        <form method="POST" action="{{ route('admin.users.updatePassword', $user->id) }}" onsubmit="return checkPasswordMatch();">
            @csrf
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                <input type="password" name="password" id="password" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required placeholder="Nhập mật khẩu mới">
                @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required placeholder="Nhập lại mật khẩu mới">
                <div id="password-match-error" class="text-red-600 text-sm mt-1 hidden">Mật khẩu xác nhận không khớp.</div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition shadow">Đổi mật khẩu</button>
            </div>
        </form>
        <script>
        function checkPasswordMatch() {
            var pw = document.getElementById('password').value;
            var pwc = document.getElementById('password_confirmation').value;
            var error = document.getElementById('password-match-error');
            if (pw !== pwc) {
                error.classList.remove('hidden');
                return false;
            } else {
                error.classList.add('hidden');
                return true;
            }
        }
        </script>
    </div>
</div>
@endsection
