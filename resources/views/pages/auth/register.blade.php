@extends('master')

@section('content')
<div class="max-w-md mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-200">
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Create an account</h2>
        <p class="text-gray-500 text-sm">Join our professional management system</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-md shadow-sm">
            <p class="font-bold mb-1 underline">Please fix these errors:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" required 
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-md font-bold hover:bg-indigo-700 transition duration-150 shadow-md">
            Create Account
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Log in</a>
    </p>
</div>
@endsection