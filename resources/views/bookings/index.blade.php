@extends('layouts.app')

@section('title', 'My Bookings - Zootopia')

@section('content')
<div class="bg-slate-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-display font-bold text-slate-900">My Dashboard</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Summary -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm text-center">
                    <div class="w-20 h-20 bg-primary-100 text-primary-700 rounded-full flex items-center justify-center font-bold text-2xl mx-auto mb-4">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">{{ Auth::user()->name }}</h2>
                    <p class="text-slate-500 text-sm mb-4">{{ Auth::user()->email }}</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-600">
                        {{ ucfirst(Auth::user()->role) }} Member
                    </span>
                </div>
            </div>

            <!-- Main Content: Tabs for Tickets & Adoptions -->
            <div class="lg:col-span-2" x-data="{ tab: 'tickets' }">
                
                <div class="flex gap-4 mb-6 border-b border-slate-200 pb-px">
                    <button @click="tab = 'tickets'" :class="{'border-primary-600 text-primary-600': tab === 'tickets', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'tickets'}" class="px-4 py-3 border-b-2 font-medium transition-colors focus:outline-none">
                        My Tickets ({{ $tickets->count() }})
                    </button>
                    <button @click="tab = 'adoptions'" :class="{'border-primary-600 text-primary-600': tab === 'adoptions', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': tab !== 'adoptions'}" class="px-4 py-3 border-b-2 font-medium transition-colors focus:outline-none">
                        My Adoptions ({{ $adoptions->count() }})
                    </button>
                </div>

                <!-- Tickets Tab -->
                <div x-show="tab === 'tickets'" x-cloak>
                    @if($tickets->isEmpty())
                        <div class="bg-white rounded-3xl p-12 border border-slate-200 shadow-sm text-center">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">No tickets yet</h3>
                            <p class="text-slate-500 mb-6">You haven't booked any visits to the zoo.</p>
                            <a href="{{ route('tickets.index') }}" class="inline-flex px-6 py-2 bg-primary-600 text-white rounded-full font-medium hover:bg-primary-700 transition-colors">Book a Ticket</a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($tickets as $ticket)
                                @php
                                    $isUpcoming = $ticket->visit_date >= now()->startOfDay();
                                @endphp
                                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col sm:flex-row group relative">
                                    @if($ticket->status === 'cancelled')
                                        <div class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-10 flex items-center justify-center">
                                            <span class="bg-red-100 text-red-800 font-bold px-4 py-2 rounded-lg border border-red-200 transform rotate-12 text-lg shadow-sm">CANCELLED</span>
                                        </div>
                                    @endif
                                    
                                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-6 flex flex-col justify-center items-center sm:w-48 shrink-0 relative overflow-hidden">
                                        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                                        <span class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-1">Visit Date</span>
                                        <span class="text-4xl font-display font-bold">{{ $ticket->visit_date->format('d') }}</span>
                                        <span class="text-lg font-medium">{{ $ticket->visit_date->format('M Y') }}</span>
                                    </div>
                                    <div class="p-6 flex-1 flex flex-col justify-center">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="font-bold text-lg text-slate-900 mb-1">Zoo Entry Ticket</h3>
                                                <p class="text-sm text-slate-500 font-mono">Booking #{{ substr($ticket->id, 0, 8) }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $isUpcoming ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $isUpcoming ? 'Upcoming' : 'Past Visit' }}
                                            </span>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                                            <div>
                                                <span class="text-slate-500 block mb-0.5">Quantity</span>
                                                <span class="font-medium text-slate-900">{{ collect($ticket->quantities)->sum() }} tickets</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500 block mb-0.5">Total Paid</span>
                                                <span class="font-medium text-slate-900">${{ number_format($ticket->total_price, 2) }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($ticket->status !== 'cancelled')
                                            <div class="border-t border-slate-100 pt-4 flex justify-end">
                                                <a href="{{ route('bookings.download', $ticket->id) }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    Download PDF Ticket
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Adoptions Tab -->
                <div x-show="tab === 'adoptions'" x-cloak>
                    @if($adoptions->isEmpty())
                        <div class="bg-white rounded-3xl p-12 border border-slate-200 shadow-sm text-center">
                            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            <h3 class="text-lg font-bold text-slate-900 mb-2">No adoptions yet</h3>
                            <p class="text-slate-500 mb-6">You haven't adopted any animals yet.</p>
                            <a href="{{ route('adopt.index') }}" class="inline-flex px-6 py-2 bg-primary-600 text-white rounded-full font-medium hover:bg-primary-700 transition-colors">Adopt an Animal</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($adoptions as $adoption)
                                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col group relative">
                                    <div class="h-32 bg-slate-100 relative overflow-hidden">
                                        @if($adoption->animal->thumbnail)
                                            <img src="{{ asset('storage/' . $adoption->animal->thumbnail) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-primary-100 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-primary-200" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <h3 class="text-xl font-display font-bold text-white">{{ $adoption->animal->name }}</h3>
                                            <p class="text-sm text-slate-300">{{ $adoption->animal->species->name }}</p>
                                        </div>
                                    </div>
                                    <div class="p-6 flex-1 flex flex-col">
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs font-bold uppercase tracking-wider">
                                                Adoption Active
                                            </span>
                                            <span class="text-sm text-slate-500 border-l border-slate-200 pl-2">Since {{ $adoption->start_date->format('M Y') }}</span>
                                        </div>
                                        
                                        <div class="mt-auto pt-4 border-t border-slate-100 flex justify-between items-center">
                                            <a href="{{ route('animals.show', $adoption->animal) }}" class="text-sm font-medium text-slate-600 hover:text-primary-600 transition-colors">View Animal</a>
                                            <a href="{{ route('adopt.certificate', $adoption->id) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-primary-600 hover:text-primary-700 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Certificate
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
        
    </div>
</div>
@endsection
