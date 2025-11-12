<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actor Submission</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        @if ($errors->any())
            <div id="error-messages" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
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

</body>
</html>
