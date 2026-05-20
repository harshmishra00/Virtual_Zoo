@extends('layouts.app')

@section('title', 'Animal Directory - Zootopia')

@section('content')
<div class="bg-slate-900 py-16 text-white relative overflow-hidden">
    <!-- Abstract shapes -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-primary-600/20 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-accent-600/20 blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-display font-bold tracking-tight mb-4">Our Animals</h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto">Discover the incredible diversity of wildlife at Zootopia. Search, filter, and learn about our amazing residents.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @livewire('animal-directory')
</div>
@endsection
