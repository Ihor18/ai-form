@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Actor Submissions</h2>
            <a href="{{ route('actors.create') }}"
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Create Actor
            </a>
        </div>

        {{-- Виведення помилок --}}
        @if ($errors->any())
            <div id="error-messages" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($actors->isEmpty())
            <p class="text-gray-500">No submissions yet.</p>
        @else
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">First Name</th>
                    <th class="py-2 px-4 border-b text-left">Address</th>
                    <th class="py-2 px-4 border-b text-left">Gender</th>
                    <th class="py-2 px-4 border-b text-left">Height</th>
                </tr>
                </thead>
                <tbody>
                @foreach($actors as $actor)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $actor->first_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $actor->address }}</td>
                        <td class="py-2 px-4 border-b">{{ $actor->gender ?? '—' }}</td>
                        <td class="py-2 px-4 border-b">{{ $actor->height ?? '—' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
