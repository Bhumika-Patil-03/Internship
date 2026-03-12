<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <nav class="bg-white shadow-sm border-b border-gray-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="text-xl font-bold text-indigo-600">MY PROJECT</div>
            <div class="space-x-4">
                @auth
                    <span class="text-gray-600">Hi, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-indigo-600">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>