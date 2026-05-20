@extends('layouts.app')

@section('title', 'About Us - Zootopia')

@section('content')
<!-- Hero -->
<div class="bg-primary-900 py-24 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1518173946687-a4c8892bbd9f?q=80&w=2000&auto=format&fit=crop')] bg-cover bg-center opacity-30 mix-blend-overlay"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-primary-900 via-primary-900/60 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-6xl font-display font-bold tracking-tight mb-6">Our Mission</h1>
        <p class="text-xl text-primary-100 max-w-3xl mx-auto font-medium">To inspire a deeper connection with nature through education, conservation, and unforgettable experiences.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <!-- Story -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
        <div>
            <h2 class="text-3xl font-display font-bold text-slate-900 mb-6">A Legacy of Conservation</h2>
            <div class="prose prose-lg text-slate-600">
                <p>Founded with a futuristic vision, Zootopia began with a simple idea: to create a revolutionary digital sanctuary where people can learn about wildlife without capturing or confining physical animals.</p>
                <p>Over the past few years, we have evolved from a small digital project into a globally recognized virtual center for wildlife preservation and education. Our dedicated team of developers, zoologists, and educators work tirelessly to ensure the highest standards of digital simulation and remote conservation funding.</p>
                <p>Today, Zootopia virtually hosts over 200 species, many of which are part of critical international breeding programs that our platform directly funds to save endangered populations from the brink of extinction.</p>
            </div>
        </div>
        <div class="relative">
            <div class="aspect-square md:aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl">
                <img src="https://images.unsplash.com/photo-1541414779316-956a5084c0d4?q=80&w=1200&auto=format&fit=crop" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 hidden sm:block">
                <p class="text-4xl font-display font-bold text-primary-600">30+</p>
                <p class="font-bold text-slate-700">Years of Service</p>
            </div>
        </div>
    </div>

    <!-- Pillars -->
    <div class="mb-24">
        <h2 class="text-3xl font-display font-bold text-center text-slate-900 mb-12">Our Core Pillars</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200 text-center hover:-translate-y-2 transition-transform duration-300">
                <div class="w-16 h-16 bg-primary-100 text-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Conservation</h3>
                <p class="text-slate-600">We actively participate in global Species Survival Plans, focusing on breeding programs for critically endangered animals.</p>
            </div>
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200 text-center hover:-translate-y-2 transition-transform duration-300">
                <div class="w-16 h-16 bg-accent-100 text-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Education</h3>
                <p class="text-slate-600">Inspiring the next generation of wildlife defenders through interactive exhibits, school programs, and virtual tours.</p>
            </div>
            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200 text-center hover:-translate-y-2 transition-transform duration-300">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Welfare</h3>
                <p class="text-slate-600">Providing the highest standard of veterinary care, enriching habitats, and nutritional diets tailored to each individual animal.</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="bg-primary-600 rounded-3xl p-10 md:p-16 text-center text-white">
        <h2 class="text-3xl font-display font-bold mb-4">Join Our Cause</h2>
        <p class="text-primary-100 text-lg mb-8 max-w-2xl mx-auto">Every digital pass purchased and every animal adopted goes directly towards funding our real-world conservation efforts.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('adopt.index') }}" class="px-8 py-4 bg-white text-primary-700 font-bold rounded-full shadow-lg hover:bg-primary-50 transition-colors">Adopt an Animal</a>
            <a href="{{ route('tickets.index') }}" class="px-8 py-4 border-2 border-primary-400 hover:border-white text-white font-bold rounded-full transition-colors">Get Digital Access</a>
        </div>
    </div>
</div>
@endsection
