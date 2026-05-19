@extends('app')

@section('meta')
    <title>OLX Price Tracker</title>
@endsection

@section('content')

    <h1 class="text-xl font-bold mb-4">Track OLX Price</h1>

    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="mb-4 p-2 bg-yellow-100 text-yellow-700 rounded">
            {{ session('warning') }}
        </div>
    @endif

    <form method="POST" action="{{ route('subscribe.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="text-sm font-medium">Email</label>
            <input type="email"
                   name="email"
                   class="w-full border p-2 rounded"
                   value="{{ old('email') }}">

            @error('email')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">OLX URL</label>
            <input type="url"
                   name="url"
                   class="w-full border p-2 rounded"
                   value="{{ old('url') }}">

            @error('url')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
            Subscribe
        </button>
    </form>

@endsection
