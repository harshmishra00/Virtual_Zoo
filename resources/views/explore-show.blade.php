@extends('layouts.app')

@section('title', $item['name'] . ' - Zootopia')

@section('content')
<!-- Cinematic Hero Section -->
<div class="relative w-full h-[70vh] min-h-[500px] bg-slate-900 overflow-hidden">
    <!-- Background Image -->
    <img src="{{ $item['pexels_image'] }}" alt="{{ $item['name'] }}" class="absolute inset-0 w-full h-full object-cover opacity-80 transition-transform duration-1000 hover:scale-105" style="object-position: center 30%;">
    
    <!-- Gradient Overlays -->
    <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 via-transparent to-slate-50"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/30 to-transparent"></div>

    <!-- Hero Content -->
    <div class="absolute inset-0 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-20">
            <!-- Back Button -->
            <a href="{{ route($backRoute) }}" class="inline-flex items-center text-slate-300 hover:text-white font-medium transition-colors mb-8 group backdrop-blur-md bg-white/10 px-4 py-2 rounded-full border border-white/20">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to {{ str_contains($backRoute, 'flowers') ? 'Botanical Garden' : 'Wildlife Explorer' }}
            </a>

            <div class="max-w-3xl">
                <div class="flex items-center gap-4 mb-4">
                    <span class="inline-block px-4 py-1.5 bg-primary-500/20 border border-primary-400/30 text-primary-200 text-sm font-bold uppercase tracking-widest rounded-full backdrop-blur-md shadow-[0_0_15px_rgba(14,165,233,0.3)]">
                        {{ $item['category'] ?? 'Species' }}
                    </span>
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/20 text-white text-sm font-bold uppercase tracking-widest rounded-full backdrop-blur-md">
                        <span class="w-2.5 h-2.5 rounded-full {{ strtolower($item['conservation_status'] ?? '') == 'endangered' ? 'bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)]' : (strtolower($item['conservation_status'] ?? '') == 'vulnerable' ? 'bg-yellow-500 shadow-[0_0_10px_rgba(234,179,8,0.8)]' : 'bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.8)]') }} animate-pulse"></span>
                        {{ $item['conservation_status'] ?? 'Unknown Status' }}
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-display font-extrabold text-white mb-6 drop-shadow-2xl leading-tight">
                    {{ $item['name'] }}
                </h1>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="bg-slate-50 relative pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Primary Details -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Overview Card -->
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl p-8 md:p-10 shadow-2xl shadow-slate-200/50 hover:shadow-slate-300/60 transition-all duration-300">
                    <h2 class="text-3xl font-display font-bold text-slate-900 mb-6 flex items-center gap-4">
                        <span class="p-3 bg-primary-100 text-primary-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Overview
                    </h2>
                    <p class="text-lg text-slate-600 leading-relaxed font-medium">
                        {{ $item['description'] }}
                    </p>
                </div>

                <!-- Fun Fact Glass Card -->
                @if(isset($item['fun_fact']))
                <div class="bg-gradient-to-br from-primary-600 to-indigo-700 rounded-3xl p-8 md:p-10 text-white relative overflow-hidden shadow-2xl shadow-primary-500/30 group">
                    <!-- Decorative Elements -->
                    <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all duration-700"></div>
                    <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-primary-400/20 rounded-full blur-3xl group-hover:bg-primary-400/40 transition-all duration-700"></div>
                    <svg class="absolute right-0 bottom-0 opacity-10 w-48 h-48 transform translate-x-1/4 translate-y-1/4 group-hover:scale-110 transition-transform duration-700" fill="currentColor" viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    
                    <div class="relative z-10">
                        <h3 class="text-2xl font-display font-bold mb-4 flex items-center gap-3">
                            <svg class="w-8 h-8 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path></svg>
                            Fascinating Fact
                        </h3>
                        <p class="text-xl text-primary-50 leading-relaxed font-medium">
                            "{{ $item['fun_fact'] }}"
                        </p>
                    </div>
                </div>
                @endif

                {{-- ── Wikipedia Deep-Dive Card ── --}}
                @if(!empty($item['wiki']['extract']))
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl p-8 md:p-10 shadow-xl shadow-slate-200/50 overflow-hidden relative">

                    {{-- Subtle Wikipedia "W" watermark --}}
                    <div class="absolute -right-6 -bottom-6 text-[180px] font-black text-slate-100 select-none pointer-events-none leading-none">W</div>

                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-6 flex items-center gap-3 relative z-10">
                        <span class="p-2.5 bg-gray-100 text-gray-600 rounded-xl">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                        </span>
                        Wikipedia Overview
                        <span class="ml-auto text-xs font-semibold text-slate-400 bg-slate-100 px-3 py-1 rounded-full tracking-wide">From Wikipedia</span>
                    </h2>

                    <div class="flex flex-col md:flex-row gap-6 relative z-10">
                        {{-- Wikipedia Thumbnail --}}
                        @if(!empty($item['wiki']['thumbnail']))
                        <div class="flex-shrink-0">
                            <img src="{{ $item['wiki']['thumbnail'] }}"
                                 alt="{{ $item['wiki']['title'] ?? $item['name'] }}"
                                 class="w-full md:w-48 h-48 object-cover rounded-2xl shadow-lg border border-slate-200">
                        </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="text-slate-600 leading-relaxed text-base mb-5">
                                {{ $item['wiki']['extract'] }}
                            </p>

                            @if(!empty($item['wiki']['url']))
                            <a href="{{ $item['wiki']['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-700 text-white text-sm font-bold rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                </svg>
                                Read full article on Wikipedia
                                <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Habitat Grid -->
                @if(isset($item['habitat']))
                <div class="bg-white/80 backdrop-blur-xl border border-white rounded-3xl p-8 md:p-10 shadow-xl shadow-slate-200/50">
                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <span class="p-2.5 bg-emerald-100 text-emerald-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Digital Habitat Details
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl hover:-translate-y-1 hover:shadow-md transition-all">
                            <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Biome Zone</span>
                            <span class="text-xl font-bold text-slate-800">{{ $item['habitat']['zone'] ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl hover:-translate-y-1 hover:shadow-md transition-all">
                            <span class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2">Location Code</span>
                            <span class="text-xl font-bold text-slate-800">{{ $item['habitat']['location'] ?? 'N/A' }}</span>
                        </div>

                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Sidebar Stats -->
            <div class="space-y-8">
                <!-- 3D Stat Card -->
                @if(isset($item['animal_facts']))
                <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-bl-full -z-10"></div>
                    
                    <h3 class="font-display font-bold text-2xl text-slate-900 mb-8 flex items-center gap-3">
                        <span class="p-2 bg-slate-100 text-slate-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </span>
                        Species Data
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                                </div>
                                <span class="text-slate-500 font-medium">Diet</span>
                            </div>
                            <span class="font-bold text-slate-900 text-right">{{ $item['animal_facts']['diet'] ?? 'N/A' }}</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-slate-500 font-medium">Lifespan</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $item['animal_facts']['age'] ?? 'N/A' }} yrs</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                                </div>
                                <span class="text-slate-500 font-medium">Weight</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $item['animal_facts']['weight_kg'] ?? 0 }} kg</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                </div>
                                <span class="text-slate-500 font-medium">Height</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $item['animal_facts']['height_cm'] ?? 0 }} cm</span>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-slate-500 font-medium">Date Added</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ isset($item['animal_facts']['arrival_date']) ? \Carbon\Carbon::parse($item['animal_facts']['arrival_date'])->format('M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
