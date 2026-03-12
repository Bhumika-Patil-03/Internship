@extends('master')

@section('content')
<div class="max-w-md mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-200">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Log in to your account</h2>
        <p class="text-gray-500 text-sm">Enter your email and password below</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Email address</label>
            <input type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md font-bold hover:bg-indigo-700 transition">
            Log in
        </button>
    </form>
    
    <p class="mt-6 text-center text-sm text-gray-600">
        Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 font-bold">Sign up</a>
    </p>
</div>
@endsection