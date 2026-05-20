@extends('layouts.app')

@section('title', 'Dynamic Image Gallery')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-900">Dynamic Animal Gallery</h1>
            <p class="text-slate-500 mt-1">Live images fetched directly from the Pexels API.</p>
        </div>
        
        <form action="{{ url('/animals') }}" method="GET" class="flex gap-2 w-full md:w-auto">
            <input type="text" name="animal" value="{{ $displayQuery }}" placeholder="e.g. tiger, fox, elephant" class="rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50 flex-1 md:w-64">
            <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-primary-700 transition-colors">Search</button>
        </form>
    </div>

    @if(empty($images))
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
            <p class="text-slate-500">No images found for "{{ $query }}".</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($images as $image)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group">
                    <div class="aspect-square relative overflow-hidden bg-slate-100">
                        <img src="{{ $image['src']['medium'] }}" alt="{{ $image['alt'] ?? 'animal' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-4 flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500 truncate">By {{ $image['photographer'] }}</span>
                        <a href="{{ $image['url'] }}" target="_blank" class="text-xs text-primary-600 hover:text-primary-700 font-bold">View Source</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
