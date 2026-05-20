@extends('layouts.app')

@section('title', 'Feeding Schedule - Zootopia')

@section('content')
<div class="bg-primary-900 py-16 text-white relative overflow-hidden">
    <!-- Abstract pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#10b981 2px, transparent 2px); background-size: 30px 30px;"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-4xl md:text-5xl font-display font-bold tracking-tight mb-4 text-center">Daily Feeding Schedule</h1>
        <p class="text-lg text-primary-100 max-w-2xl mx-auto text-center">Log in for these exciting virtual events! Watch our digital handlers interact with the animals and learn fascinating facts via our 4K streams.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12 bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Today's Timeline</h2>
            <p class="text-slate-500">{{ now()->format('l, F jS') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <span class="px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg border border-slate-200">All</span>
            <span class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-500 font-medium rounded-lg border border-slate-200 cursor-pointer transition-colors">Morning</span>
            <span class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-500 font-medium rounded-lg border border-slate-200 cursor-pointer transition-colors">Afternoon</span>
        </div>
    </div>

    <!-- Timeline View -->
    <div class="relative wrap overflow-hidden p-4 sm:p-10 h-full">
        <!-- Vertical Line -->
        <div class="absolute border-opacity-20 border-slate-400 h-full border-l-2 left-1/2 transform -translate-x-1/2 hidden md:block"></div>
        
        @php $isRight = false; @endphp
        @foreach($schedules as $schedule)
            <div class="mb-8 flex justify-between items-center w-full {{ $isRight ? 'flex-row-reverse' : '' }} flex-col md:flex-row">
                <!-- Empty Space for Grid -->
                <div class="order-1 w-full md:w-5/12"></div>
                
                <!-- Timeline Dot -->
                <div class="z-20 flex items-center order-1 bg-primary-600 shadow-xl w-12 h-12 rounded-full absolute left-1/2 transform -translate-x-1/2 mt-0 md:mt-0 hidden md:flex border-4 border-white">
                    <svg class="mx-auto text-white w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                
                <!-- Content Card -->
                <div class="order-1 bg-white rounded-3xl border border-slate-200 shadow-sm w-full md:w-5/12 overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="flex items-center justify-between px-6 py-4 bg-slate-50 border-b border-slate-100">
                        <h3 class="font-display font-bold text-xl text-slate-900">{{ \Carbon\Carbon::parse($schedule->feed_time)->format('h:i A') }}</h3>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">{{ $schedule->period }}</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-4">
                            @if($schedule->animal->thumbnail)
                                <img src="{{ asset('storage/' . $schedule->animal->thumbnail) }}" class="w-16 h-16 rounded-xl object-cover">
                            @else
                                <div class="w-16 h-16 bg-slate-200 rounded-xl flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="font-bold text-lg text-slate-900 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('animals.show', $schedule->animal) }}">{{ $schedule->animal->name }}</a>
                                </h4>
                                <p class="text-slate-500 text-sm">{{ $schedule->animal->species->name }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-3 mt-4 text-sm">
                            <div class="flex items-start gap-3">
                                <div class="text-slate-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                <div>
                                    <span class="font-medium text-slate-700">Virtual Environment:</span> 
                                    <span class="text-slate-600">{{ $schedule->animal->enclosure->name }}</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="text-slate-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                                <div>
                                    <span class="font-medium text-slate-700">Diet:</span> 
                                    <span class="text-slate-600">{{ $schedule->food_type }}</span>
                                </div>
                            </div>
                            @if($schedule->notes)
                            <div class="flex items-start gap-3">
                                <div class="text-slate-400 mt-0.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                                <div class="text-slate-600 italic">"{{ $schedule->notes }}"</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @php $isRight = !$isRight; @endphp
        @endforeach
    </div>
</div>
@endsection
