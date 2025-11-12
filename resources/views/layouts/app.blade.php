<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actor Submission</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<nav class="bg-white shadow-md mb-6">
    <div class="max-w-5xl mx-auto px-4 py-4 flex justify-between">
        <h1 class="text-xl font-semibold text-gray-700">🎬 Actor Form</h1>
        <a href="{{ route('actors.index') }}" class="text-blue-600 hover:underline">Submissions</a>
    </div>
</nav>

<main class="flex-grow">
    <div class="max-w-3xl mx-auto px-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="bg-white shadow-inner mt-6 py-4 text-center text-gray-500 text-sm">
    Laravel Test Task © {{ date('Y') }}
</footer>
</body>
</html>
