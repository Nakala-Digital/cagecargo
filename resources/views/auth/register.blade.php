@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="mx-auto w-24 h-24 bg-white rounded-xl flex items-center justify-center mb-4 shadow-sm">
                <img src="{{ asset('logo.png') }}" alt="CargoGate" class="w-full h-full object-contain p-2">
            </div>
            <h2 class="text-3xl font-bold text-navy">CargoGate</h2>
            <p class="mt-2 text-sm text-gray-600">Buat Akun Baru</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-xl font-semibold text-navy mb-6">Register</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('name') border-red-500 @enderror">
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('email') border-red-500 @enderror">
                    @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('role') border-red-500 @enderror">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operasional" {{ old('role') == 'operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="finance" {{ old('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                        <option value="ppjk" {{ old('role') == 'ppjk' ? 'selected' : '' }}>PPJK</option>
                    </select>
                    @error('role') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('password') border-red-500 @enderror">
                    @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>

                <button type="submit"
                    class="w-full bg-teal hover:bg-teal-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200">
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-teal hover:text-teal-600 font-medium">Sign In</a>
            </p>
        </div>
    </div>
</div>
@endsection
