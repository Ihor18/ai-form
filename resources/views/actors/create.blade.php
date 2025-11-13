@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Add Actor Information</h2>

        <form method="POST" id="actor-form" class="space-y-5">
            <div id="error-messages" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 hidden">
                <ul class="list-disc pl-5"></ul>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Actor Description</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">
                    Please enter your first name and last name, and also provide your address.
                </p>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Submit
            </button>
        </form>
    </div>
@endsection
