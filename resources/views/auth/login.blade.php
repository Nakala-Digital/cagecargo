@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="mx-auto w-24 h-24 bg-white rounded-xl flex items-center justify-center mb-4 shadow-sm">
                <img src="{{ asset('logo.png') }}" alt="CargoGate" class="w-full h-full object-contain p-2">
            </div>
            <h2 class="text-3xl font-bold text-navy">CargoGate</h2>
            <p class="mt-2 text-sm text-gray-600">Logistics Management System</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-xl font-semibold text-navy mb-6">Sign In</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal transition-colors @error('email') border-red-500 @enderror"
                        placeholder="your@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal focus:border-teal transition-colors @error('password') border-red-500 @enderror"
                        placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-teal focus:ring-teal">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-teal hover:bg-teal-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200">
                    Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider text-center mb-3">Demo Credentials</p>
                <div class="space-y-1.5">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Admin</span>
                        <span class="text-gray-400 font-mono">admin@cargogate.com / password</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Operasional</span>
                        <span class="text-gray-400 font-mono">ops@cargogate.com / password</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">Finance</span>
                        <span class="text-gray-400 font-mono">finance@cargogate.com / password</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-500">PPJK</span>
                        <span class="text-gray-400 font-mono">ppjk@cargogate.com / password</span>
                    </div>
                </div>
            </div>

            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-teal hover:text-teal-600 font-medium">Register</a>
            </p>
        </div>
    </div>
</div>
@endsection
