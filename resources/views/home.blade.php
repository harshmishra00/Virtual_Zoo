@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-slate-900 min-h-[90vh] flex items-center overflow-hidden">
    <!-- background video or image -->
    <div class="absolute inset-0">
        <img src="https://images.pexels.com/photos/1650825/pexels-photo-1650825.jpeg" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center z-10 w-full flex flex-col items-center">
        <span class="inline-block py-1.5 px-5 rounded-full bg-primary-500/20 text-primary-300 backdrop-blur-md border border-primary-500/30 text-sm font-semibold tracking-widest uppercase mb-8 animate-pulse">
            Experience Nature Digitally
        </span>
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-display font-extrabold text-white tracking-tighter mb-8 drop-shadow-2xl leading-tight">
            The World's Premier <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 via-accent-400 to-primary-500">Virtual Zoo</span>
        </h1>
        <p class="mt-4 max-w-3xl mx-auto text-xl md:text-2xl text-slate-300 mb-12 font-light">
            Immerse yourself in wildlife, explore exotic botanical gardens, take a 4K virtual tour, or dive into our deep sea aquarium—all from your browser.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-6 w-full max-w-lg mx-auto">
            <a href="{{ route('tour') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-primary-600 hover:bg-primary-500 text-white font-bold text-lg shadow-[0_0_30px_rgba(14,165,233,0.5)] transition-all hover:-translate-y-1 hover:scale-105">
                Start Virtual Tour
            </a>
            <a href="#explore" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 font-bold text-lg transition-all hover:-translate-y-1">
                See Features
            </a>
        </div>
    </div>
</div>

<!-- Features Section (Bento Grid Style) -->
<div id="explore" class="py-24 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 mb-4 tracking-tight">Discover the Wonders</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Explore thousands of highly accurate species loaded dynamically with stunning Pexels photography.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Animals Card -->
            <a href="{{ route('animals.index') }}" class="group relative rounded-[2rem] overflow-hidden aspect-square shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 lg:col-span-2">
                <img src="https://images.pexels.com/photos/24991332/pexels-photo-24991332.jpeg" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/60 to-slate-900/20"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 sm:p-12">
                    <h3 class="text-4xl font-display font-bold text-white mb-3 drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)]">Wildlife Directory</h3>
                    <p class="text-slate-300 text-lg mb-6 max-w-md opacity-80 sm:opacity-0 sm:group-hover:opacity-100 transform sm:translate-y-4 sm:group-hover:translate-y-0 transition-all duration-500">Browse mammals, birds, reptiles, and more with high-definition dynamic imagery.</p>
                    <span class="inline-flex items-center text-primary-400 font-bold bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">Explore Animals &rarr;</span>
                </div>
            </a>

            <!-- Flowers Card -->
            <a href="{{ route('flowers.index') }}" class="group relative rounded-[2rem] overflow-hidden aspect-square shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <img src="https://images.pexels.com/photos/1083822/pexels-photo-1083822.jpeg" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-950/95 via-emerald-900/60 to-emerald-900/30"></div>
                <div class="absolute bottom-0 left-0 w-full p-8">
                    <h3 class="text-3xl font-display font-bold text-white mb-3 drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)]">Botanical Garden</h3>
                    <p class="text-emerald-100 text-sm mb-6 opacity-80 sm:opacity-0 sm:group-hover:opacity-100 transform sm:translate-y-4 sm:group-hover:translate-y-0 transition-all duration-500">A vibrant collection of the world's most beautiful flowers.</p>
                    <span class="inline-flex items-center text-emerald-400 font-bold bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">Explore Flowers &rarr;</span>
                </div>
            </a>

            <!-- Aquarium Card -->
            <a href="{{ route('aquarium') }}" class="group relative rounded-[2rem] overflow-hidden aspect-square md:aspect-[4/3] shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 lg:col-span-1">
                <img src="https://images.pexels.com/photos/2156311/pexels-photo-2156311.jpeg" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/95 via-blue-900/60 to-blue-900/30"></div>
                <div class="absolute bottom-0 left-0 w-full p-8">
                    <h3 class="text-3xl font-display font-bold text-white mb-3 drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)]">4K Aquarium</h3>
                    <p class="text-blue-100 text-sm mb-6 opacity-80 sm:opacity-0 sm:group-hover:opacity-100 transform sm:translate-y-4 sm:group-hover:translate-y-0 transition-all duration-500">Immersive, full-screen underwater experience.</p>
                    <span class="inline-flex items-center text-blue-400 font-bold bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">Dive In &rarr;</span>
                </div>
            </a>

            <!-- Tour Card -->
            <a href="{{ route('tour') }}" class="group relative rounded-[2rem] overflow-hidden aspect-square md:aspect-[4/3] lg:aspect-auto shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 lg:col-span-2">
                <img src="https://images.pexels.com/photos/247376/pexels-photo-247376.jpeg" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-purple-950/95 via-purple-900/60 to-purple-900/30"></div>
                <div class="absolute bottom-0 left-0 w-full p-8 sm:p-12">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold uppercase tracking-widest border border-white/40 drop-shadow-md">Interactive</span>
                    </div>
                    <h3 class="text-4xl font-display font-bold text-white mb-3 drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)]">Randomized Safari Tour</h3>
                    <p class="text-purple-100 text-lg mb-6 max-w-md opacity-80 sm:opacity-0 sm:group-hover:opacity-100 transform sm:translate-y-4 sm:group-hover:translate-y-0 transition-all duration-500">Swipe through an endless, algorithmically generated journey across all our habitats.</p>
                    <span class="inline-flex items-center text-purple-400 font-bold bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">Start Tour &rarr;</span>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Adoption CTA Section -->
<div class="relative py-24 overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-gradient-to-br from-primary-600 to-accent-600 rounded-[3rem] p-10 md:p-20 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-12 overflow-hidden relative border border-primary-500/20">
            <!-- decorative circles -->
            <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-96 h-96 rounded-full bg-black/10 blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 lg:w-2/3 text-center lg:text-left">
                <span class="inline-block py-1 px-4 rounded-full bg-white/20 text-white backdrop-blur-md text-sm font-bold tracking-widest uppercase mb-6">
                    Conservation
                </span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6 drop-shadow-md">Make a Real Difference</h2>
                <p class="text-primary-50 text-xl mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    By virtually adopting an animal, you support global wildlife conservation efforts. Receive a personalized adoption certificate and exclusive updates.
                </p>
                <a href="{{ route('adopt.index') }}" class="inline-flex items-center justify-center px-10 py-5 rounded-full text-lg font-bold text-primary-700 bg-white shadow-xl hover:shadow-2xl transition-all hover:-translate-y-1 hover:scale-105">
                    Adopt an Animal Today
                </a>
            </div>
            
            <div class="relative z-10 lg:w-1/3 flex justify-center">
                <div class="w-64 h-64 md:w-80 md:h-80 rounded-full border-[12px] border-white/20 overflow-hidden shadow-[0_0_40px_rgba(0,0,0,0.3)]">
                    <img src="https://images.pexels.com/photos/4577821/pexels-photo-4577821.jpeg" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
