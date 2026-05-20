@extends('layouts.app')

@section('title', $title . ' - Zootopia')

@section('content')
<div class="bg-slate-900 py-16 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1544829728-e5cb9eedc20e?q=80&w=2000&auto=format&fit=crop')] bg-cover bg-center opacity-20 mix-blend-luminosity"></div>
    <div class="max-w-3xl mx-auto px-4 relative z-10">
        <h1 class="text-4xl md:text-5xl font-display font-bold mb-4">{{ $title }}</h1>
        <p class="text-lg text-slate-300">{{ $description }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Bar -->
    <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 mb-12 transform -translate-y-20 relative z-20 max-w-4xl mx-auto">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ $query }}" placeholder="Search by name or description..." class="w-full pl-12 pr-4 py-4 rounded-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 bg-slate-50 text-slate-900">
            </div>
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg shadow-primary-500/30 whitespace-nowrap">
                Explore
            </button>
            @if($query)
                <a href="{{ url()->current() }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-4 rounded-xl font-bold transition-all whitespace-nowrap flex items-center justify-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Results Grid -->
    @if(count($paginator) > 0)
        <div id="explore-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($paginator as $item)
                @php 
                    $isFlower = isset($item['category']) && str_contains(strtolower($item['category']), 'flower');
                    $route = $isFlower ? route('flowers.show', $item['slug']) : route('animals.show', $item['slug']);
                @endphp
                <a href="{{ $route }}" target="_blank" class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 group flex flex-col h-full relative">
                    <!-- Category Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        <span class="bg-white/90 backdrop-blur-sm text-primary-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                            {{ $item['category'] ?? 'Species' }}
                        </span>
                    </div>

                    <div class="aspect-[4/3] overflow-hidden relative bg-slate-200">
                        <img src="{{ $item['pexels_image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <span class="text-white text-sm font-medium line-clamp-2">{{ $item['fun_fact'] ?? '' }}</span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-2xl font-display font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $item['name'] }}</h3>
                        </div>
                        
                        <div class="mb-4">
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded bg-slate-100 text-slate-600">
                                <span class="w-2 h-2 rounded-full {{ strtolower($item['conservation_status'] ?? '') == 'endangered' ? 'bg-red-500' : (strtolower($item['conservation_status'] ?? '') == 'vulnerable' ? 'bg-yellow-500' : 'bg-green-500') }}"></span>
                                {{ $item['conservation_status'] ?? 'Unknown' }}
                            </span>
                        </div>
                        
                        <p class="text-slate-600 text-sm mb-6 flex-1 line-clamp-3">{{ $item['description'] }}</p>
                        
                        <div class="border-t border-slate-100 pt-4 mt-auto">
                            <div class="text-xs">
                                <div>
                                    <span class="text-slate-400 block mb-0.5">Location</span>
                                    <span class="font-semibold text-slate-700">{{ $item['habitat']['zone'] ?? 'Unknown' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $paginator->links() }}
        </div>
    @else
        <div class="text-center py-24 bg-white rounded-3xl border border-slate-100">
            <svg class="w-20 h-20 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-xl font-bold text-slate-900 mb-2">No results found</h3>
            <p class="text-slate-500">We couldn't find anything matching "{{ $query }}".</p>
            <a href="{{ url()->current() }}" class="inline-block mt-6 text-primary-600 font-bold hover:text-primary-700">Clear Search</a>
        </div>
    @endif
</div>
@endsection
