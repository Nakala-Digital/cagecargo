@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="text-center">
        <div class="mx-auto w-20 h-20 bg-teal rounded-2xl flex items-center justify-center mb-6">
            <span class="text-3xl font-bold text-white">CG</span>
        </div>
        <h1 class="text-4xl font-bold text-navy mb-2">CargoGate</h1>
        <p class="text-lg text-gray-500 mb-8">Logistics Management System</p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors font-medium">Sign In</a>
            <a href="{{ route('register') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">Register</a>
        </div>
    </div>
</div>
@endsection
