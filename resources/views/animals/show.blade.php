@extends('layouts.app')

@section('title', $animal->name . ' - Zootopia')

@section('content')
<!-- Hero Section -->
<div class="relative bg-slate-900 h-[60vh] min-h-[400px]">
    @if($animal->thumbnail)
        <img src="{{ asset('storage/' . $animal->thumbnail) }}" alt="{{ $animal->name }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
    @else
        <div class="absolute inset-0 bg-slate-800 flex items-center justify-center">
            <svg class="w-32 h-32 text-slate-700" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
        </div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
    
    <div class="absolute bottom-0 inset-x-0 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white rounded-full text-xs font-bold uppercase tracking-widest">{{ $animal->species->name }}</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border @badgeColor($animal->conservation_status) bg-white/10 backdrop-blur-md text-white border-white/20">
                        <span class="w-2 h-2 rounded-full {{ \App\Helpers\ZooHelper::badgeDotColor($animal->conservation_status) }}"></span>
                        {{ $animal->conservation_status }}
                    </span>
                </div>
                <h1 class="text-5xl md:text-7xl font-display font-bold text-white tracking-tight">{{ $animal->name }}</h1>
            </div>
            <div class="flex shrink-0 gap-3">
                <a href="{{ route('adopt.index', ['animal' => $animal->id]) }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-bold rounded-xl shadow-lg hover:-translate-y-1 transition-transform flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Adopt This Animal
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-12">
            
            <!-- About Section -->
            <section>
                <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">About the {{ $animal->name }}</h2>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                    <p>{{ $animal->description ?? 'We are currently updating our records for this animal. Please check back later for a detailed description.' }}</p>
                </div>
                
                @if($animal->fun_fact)
                    <div class="mt-8 bg-accent-50 border-l-4 border-accent-500 p-6 rounded-r-2xl">
                        <div class="flex items-start gap-4">
                            <div class="bg-accent-100 p-2 rounded-lg text-accent-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-accent-900 mb-1">Fun Fact!</h3>
                                <p class="text-accent-800">{{ $animal->fun_fact }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </section>

            <!-- Gallery -->
            @if($animal->images->count() > 0)
                <section x-data="{ 
                    activeImg: '{{ asset('storage/' . $animal->images->first()->image_path) }}',
                    images: {{ $animal->images->pluck('image_path')->map(fn($path) => asset('storage/'.$path))->toJson() }},
                    currentIndex: 0 
                }">
                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-6">Gallery</h2>
                    
                    <!-- Main Image -->
                    <div class="relative aspect-video bg-slate-100 rounded-3xl overflow-hidden mb-4 group">
                        <img :src="images[currentIndex]" class="w-full h-full object-cover transition-opacity duration-300" alt="Gallery Image">
                        
                        <!-- Navigation Arrows -->
                        <div class="absolute inset-0 flex items-center justify-between p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1" class="p-2 rounded-full bg-black/50 text-white hover:bg-black/70 backdrop-blur-sm transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button @click="currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0" class="p-2 rounded-full bg-black/50 text-white hover:bg-black/70 backdrop-blur-sm transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Thumbnails -->
                    <div class="flex gap-4 overflow-x-auto pb-4 snap-x">
                        <template x-for="(img, index) in images" :key="index">
                            <button @click="currentIndex = index" :class="{'ring-2 ring-primary-500 ring-offset-2': currentIndex === index}" class="relative shrink-0 w-24 h-24 rounded-xl overflow-hidden snap-start focus:outline-none transition-all">
                                <img :src="img" class="w-full h-full object-cover" alt="Thumbnail">
                                <div :class="{'opacity-0': currentIndex === index, 'opacity-40': currentIndex !== index}" class="absolute inset-0 bg-black transition-opacity"></div>
                            </button>
                        </template>
                    </div>
                </section>
            @endif

            <!-- Visitor Reviews -->
            <section>
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-display font-bold text-slate-900">Visitor Reviews</h2>
                    <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full border border-slate-200">
                        <svg class="w-5 h-5 text-accent-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        <span class="font-bold text-slate-900">{{ number_format($animal->averageRating(), 1) }}</span>
                        <span class="text-slate-500 text-sm">({{ $animal->reviews->count() }})</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @forelse($animal->reviews as $review)
                        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-bold">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-slate-900 text-sm">{{ $review->user->name }}</div>
                                    <div class="text-slate-500 text-xs">{{ $review->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="ml-auto flex text-accent-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-accent-500' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    @endfor
                                </div>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-2">{{ $review->title }}</h4>
                            <p class="text-slate-600 text-sm italic">"{{ $review->body }}"</p>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-slate-500">
                            No reviews yet. Be the first to review!
                        </div>
                    @endforelse
                </div>

                @auth
                    @livewire('review-form', ['animalId' => $animal->id])
                @else
                    <div class="bg-primary-50 rounded-2xl p-6 text-center border border-primary-100">
                        <p class="text-primary-800 font-medium mb-3">Want to share your experience?</p>
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-primary-600 text-white rounded-full text-sm font-bold hover:bg-primary-700 transition-colors">Log in to write a review</a>
                    </div>
                @endauth
            </section>

        </div>

        <!-- Sidebar / Details Cards -->
        <div class="space-y-8">
            
            <!-- Quick Info Grid -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="font-bold text-slate-900">Animal Facts</h3>
                </div>
                <div class="p-6 grid grid-cols-2 gap-x-4 gap-y-6">
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Age</div>
                        <div class="font-medium text-slate-900">{{ $animal->age ?? 'Unknown' }} {{ $animal->age ? 'Years' : '' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Gender</div>
                        <div class="font-medium text-slate-900 capitalize">{{ $animal->gender }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Weight</div>
                        <div class="font-medium text-slate-900">{{ $animal->weight_kg ?? '?' }} kg</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Height/Length</div>
                        <div class="font-medium text-slate-900">{{ $animal->height_cm ?? '?' }} cm</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Diet</div>
                        <div class="font-medium text-slate-900">{{ $animal->diet ?? 'Mixed' }}</div>
                    </div>
                    <div class="col-span-2">
                        <div class="text-xs font-semibold text-slate-500 uppercase mb-1">Arrival Date</div>
                        <div class="font-medium text-slate-900">{{ $animal->arrival_date ? $animal->arrival_date->format('F Y') : 'Born at Zoo' }}</div>
                    </div>
                </div>
            </div>

            <!-- Habitat & Enclosure -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute inset-0 opacity-20 group-hover:opacity-30 transition-opacity">
                    @if($animal->enclosure->habitat->image)
                        <img src="{{ asset('storage/' . $animal->enclosure->habitat->image) }}" class="w-full h-full object-cover">
                    @else
                        <!-- fallback pattern -->
                        <div class="w-full h-full bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                    @endif
                </div>
                <div class="relative z-10">
                    <div class="text-primary-400 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold mb-1">{{ $animal->enclosure->habitat->name }}</h3>
                    <p class="text-slate-300 mb-2">Zone: {{ $animal->enclosure->name }}</p>
                </div>
            </div>

            <!-- Feeding Schedule -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="bg-primary-50 px-6 py-4 border-b border-primary-100 flex items-center justify-between">
                    <h3 class="font-bold text-primary-900">Feeding Schedule</h3>
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-slate-100">
                        @forelse($animal->feedingSchedules as $schedule)
                            @php
                                $isNext = \Carbon\Carbon::parse($schedule->feed_time)->greaterThan(now()) && 
                                          (!isset($nextScheduleFound) || !$nextScheduleFound);
                                if ($isNext) $nextScheduleFound = true;
                            @endphp
                            <li class="px-6 py-4 {{ $isNext ? 'bg-primary-50/50' : '' }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-lg font-bold font-display {{ $isNext ? 'text-primary-700' : 'text-slate-900' }}">
                                        {{ \Carbon\Carbon::parse($schedule->feed_time)->format('H:i') }}
                                    </span>
                                    @if($isNext)
                                        <span class="text-[10px] font-bold uppercase tracking-wider bg-primary-100 text-primary-700 px-2 py-0.5 rounded-sm">Next</span>
                                    @endif
                                </div>
                                <div class="text-sm font-medium text-slate-700">{{ $schedule->food_type }}</div>
                                @if($schedule->notes)
                                    <div class="text-xs text-slate-500 mt-1">{{ $schedule->notes }}</div>
                                @endif
                            </li>
                        @empty
                            <li class="px-6 py-8 text-center text-slate-500 text-sm">
                                No scheduled feedings available.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
