@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Tạo tài khoản người dùng mới</h1>
    @if(session('success'))
        <div id="modal-success" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                <div class="text-green-600 text-3xl mb-2">✔</div>
                <div class="text-lg font-semibold mb-2">{{ session('success') }}</div>
                <button onclick="document.getElementById('modal-success').style.display='none'" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Đóng</button>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div id="modal-error" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-30">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
                <div class="text-red-600 text-3xl mb-2">&#10006;</div>
                <div class="text-lg font-semibold mb-2">{{ session('error') }}</div>
                <button onclick="document.getElementById('modal-error').style.display='none'" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Đóng</button>
            </div>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white shadow rounded-lg p-6" onsubmit="return checkPasswordMatch();">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required>
            @error('name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required>
            @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
            <input type="password" name="password" id="password" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required>
            @error('password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full px-3 py-2" required>
        </div>
        <div class="mb-2">
            <div id="password-match-error" class="text-red-600 text-sm mt-1 hidden">Mật khẩu xác nhận không khớp.</div>
        </div>
        <div class="flex justify-between gap-2">
            <a href="{{ route('admin.users.view') }}" class="px-6 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">← Quay lại</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-green-700 transition shadow">Tạo mới</button>
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
@endsection
