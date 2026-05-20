<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Virtual Aquarium - Zootopia</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hide-scroll-bar::-webkit-scrollbar {
            display: none;
        }
        .hide-scroll-bar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="font-sans antialiased bg-black overflow-hidden m-0 p-0 w-screen h-screen">
    
    <!-- Full Screen Container -->
    <div class="relative w-full h-full flex flex-col justify-end">

        <!-- Background Video -->
        <video class="absolute inset-0 w-full h-full object-cover pointer-events-none" autoplay loop muted playsinline>
            <source src="{{ route('video.aquarium') }}" type="video/mp4">
            <source src="{{ route('video.aquarium') }}" type="video/x-matroska">
        </video>

        <!-- Overlay Gradient for better text/image visibility at the bottom -->
        <div class="absolute inset-x-0 bottom-0 h-64 bg-gradient-to-t from-black/80 via-black/40 to-transparent pointer-events-none z-0"></div>

        <!-- Scrollable Fish List over the Video -->
        <div class="relative z-10 w-full pb-2 px-2 sm:px-4 opacity-50 hover:opacity-100 transition-opacity duration-500">
            <!-- Horizontal Scroll Container -->
            <div class="flex overflow-x-auto gap-3 sm:gap-4 pb-2 snap-x snap-mandatory hide-scroll-bar">
                @foreach($fishes as $fish)
                    <a href="{{ route('fishes.show', $fish['slug']) }}" target="_blank" class="snap-start shrink-0 group relative flex flex-col items-center hover:-translate-y-1 transition-transform duration-300">
                        
                        <!-- Fish Image -->
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden border border-white/30 group-hover:border-primary-400 shadow-md group-hover:shadow-[0_0_15px_rgba(14,165,233,0.6)] transition-all">
                            <img src="{{ $fish['pexels_image'] }}" alt="{{ $fish['name'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                        </div>
                        
                        <!-- Fish Name Tooltip / Label -->
                        <div class="mt-1 bg-black/60 backdrop-blur-md px-2 py-0.5 rounded-full border border-white/10 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg absolute bottom-full mb-1">
                            <h3 class="font-bold text-white text-[10px] sm:text-xs tracking-wide whitespace-nowrap">{{ $fish['name'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</body>
</html>
