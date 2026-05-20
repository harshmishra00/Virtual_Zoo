<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Zootopia — Virtual Zoo Portal')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-background text-slate-800 flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 group">
                        <svg class="h-8 w-8 text-primary-600 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-display font-bold text-2xl tracking-tight text-slate-900">Zoo<span class="text-primary-600">topia</span></span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="{{ route('animals.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('animals.*') ? 'border-primary-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} text-sm font-medium transition-colors">
                        Animals
                    </a>
                    <a href="{{ route('flowers.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('flowers.*') ? 'border-primary-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} text-sm font-medium transition-colors">
                        Flowers
                    </a>
                    <a href="{{ route('tour') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('tour') ? 'border-primary-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} text-sm font-medium transition-colors">
                        Tour
                    </a>
                    <a href="{{ route('aquarium') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('aquarium') ? 'border-primary-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} text-sm font-medium transition-colors">
                        Aquarium
                    </a>
                    <a href="{{ route('adopt.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('adopt.*') ? 'border-primary-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} text-sm font-medium transition-colors">
                        Adopt
                    </a>

                    @auth
                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="profileOpen" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 border border-slate-100 ring-1 ring-black ring-opacity-5">
                                @if(Auth::user()->hasAnyRole(['admin', 'staff']))
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Admin Panel</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-danger-600 hover:bg-red-50">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-b border-slate-200" x-transition>
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('animals.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('animals.*') ? 'border-primary-600 text-primary-700 bg-primary-50' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300' }} text-base font-medium">Animals</a>
                <a href="{{ route('tour') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tour') ? 'border-primary-600 text-primary-700 bg-primary-50' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300' }} text-base font-medium">Tour</a>
                <a href="{{ route('aquarium') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('aquarium') ? 'border-primary-600 text-primary-700 bg-primary-50' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300' }} text-base font-medium">Aquarium</a>
                <a href="{{ route('adopt.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('adopt.*') ? 'border-primary-600 text-primary-700 bg-primary-50' : 'border-transparent text-slate-500 hover:bg-slate-50 hover:border-slate-300' }} text-base font-medium">Adopt</a>
            </div>
            
            @auth
                <div class="pt-4 pb-1 border-t border-slate-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        @if(Auth::user()->hasAnyRole(['admin', 'staff']))
                            <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-500 hover:bg-slate-50 hover:border-slate-300">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-danger-600 hover:bg-red-50 hover:border-red-300">Log Out</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages (Toast via Alpine) -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition.opacity.duration.500ms
             class="fixed bottom-4 right-4 z-50 bg-primary-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white ml-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition.opacity.duration.500ms
             class="fixed bottom-4 right-4 z-50 bg-danger-600 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
            <button @click="show = false" class="text-white/80 hover:text-white ml-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <svg class="h-8 w-8 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-display font-bold text-2xl tracking-tight">Zoo<span class="text-primary-500">topia</span></span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        Experience the wonders of nature from anywhere. Connect with wildlife, support conservation, and learn about our planet's amazing biodiversity.
                    </p>
                </div>
                <div>
                    <h3 class="font-display font-semibold text-lg mb-4 text-white">Explore</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('animals.index') }}" class="hover:text-primary-400 transition-colors">Animals</a></li>
                        <li><a href="{{ route('flowers.index') }}" class="hover:text-primary-400 transition-colors">Flowers</a></li>
                        <li><a href="{{ route('tour') }}" class="hover:text-primary-400 transition-colors">Virtual Tours</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-display font-semibold text-lg mb-4 text-white">Get Involved</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('adopt.index') }}" class="hover:text-primary-400 transition-colors">Adopt an Animal</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors">Conservation Efforts</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-display font-semibold text-lg mb-4 text-white">Connect</h3>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('contact') }}" class="hover:text-primary-400 transition-colors">Contact Us</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-primary-400 transition-colors">About the Zoo</a></li>
                        <li class="flex gap-4 mt-4">
                            <a href="#" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-800 text-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} Zootopia. All rights reserved. Designed for educational purposes.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
