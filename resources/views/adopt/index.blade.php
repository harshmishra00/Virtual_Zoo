@extends('layouts.app')

@section('title', 'Adopt an Animal - Zootopia')

@section('content')
<div class="bg-slate-900 py-16 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1564750505-bb265287be17?q=80&w=2000&auto=format&fit=crop')] bg-cover bg-center opacity-30 mix-blend-overlay"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
    <div class="max-w-3xl mx-auto px-4 relative z-10 mt-8">
        <h1 class="text-4xl md:text-5xl font-display font-bold mb-4">Adopt an Animal</h1>
        <p class="text-lg text-slate-300">Support our conservation efforts by symbolically adopting your favorite zoo resident.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Info Column -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-primary-50 rounded-3xl p-8 border border-primary-100">
                <h3 class="text-xl font-bold text-primary-900 mb-4">Why Adopt?</h3>
                <p class="text-primary-800 text-sm mb-6 leading-relaxed">Your adoption directly funds the care, feeding, and veterinary needs of the animals, as well as our global conservation initiatives.</p>
                
                <h4 class="font-bold text-primary-900 mb-3 text-sm uppercase tracking-wide">Adoption Package Includes:</h4>
                <ul class="space-y-3 text-sm text-primary-800">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Digital Adoption Certificate
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        High-Resolution Animal Photo
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Quarterly Updates on your animal
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-primary-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Your name on the digital donor wall
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="font-bold text-slate-900 mb-2">Pricing Tiers</h3>
                <div class="space-y-2 text-sm text-slate-600">
                    <div class="flex justify-between border-b border-slate-100 pb-1"><span>1 Month</span> <span>₹500</span></div>
                    <div class="flex justify-between border-b border-slate-100 pb-1"><span>6 Months</span> <span>₹2500</span></div>
                    <div class="flex justify-between pb-1"><span>1 Year (VIP)</span> <span>₹4500</span></div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 md:p-10">
                
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl flex items-start gap-4 mb-8">
                        <svg class="w-6 h-6 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="w-full">
                            <h4 class="font-bold text-lg mb-1">Thank you for your support!</h4>
                            <p>{{ session('success') }}</p>
                            @if(session('new_adoption_id'))
                                <a href="{{ route('adopt.certificate', session('new_adoption_id')) }}" class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download Certificate
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <h3 class="text-2xl font-bold text-slate-900 mb-6">Adoption Details</h3>
                
                    <form action="{{ route('adopt.confirm') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">

                            <!-- Adopter Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Your Name</label>
                                    <input type="text" name="adopter_name" required placeholder="John Doe" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50 py-3">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                                    <input type="email" name="adopter_email" required placeholder="john@example.com" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50 py-3">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Select Animal</label>
                                <select name="animal_id" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50 py-3">
                                    <option value="">-- Choose an Animal --</option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}" {{ request('animal') == $animal->id ? 'selected' : '' }}>
                                            {{ $animal->name }} ({{ $animal->species->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('animal_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Adoption Duration & Amount (₹)</label>
                                <div class="grid grid-cols-3 gap-4 mb-3" x-data="{ duration: 1 }">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="duration_months" value="1" class="peer sr-only" x-model="duration" checked>
                                        <div class="text-center p-4 rounded-xl border-2 peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-slate-50 transition-colors">
                                            <span class="block font-bold text-lg">₹500</span>
                                            <span class="block text-xs text-slate-500">1 Month</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="duration_months" value="6" class="peer sr-only" x-model="duration">
                                        <div class="text-center p-4 rounded-xl border-2 peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-slate-50 transition-colors">
                                            <span class="block font-bold text-lg">₹2500</span>
                                            <span class="block text-xs text-slate-500">6 Months</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="duration_months" value="12" class="peer sr-only" x-model="duration">
                                        <div class="text-center p-4 rounded-xl border-2 peer-checked:border-primary-500 peer-checked:bg-primary-50 hover:bg-slate-50 transition-colors">
                                            <span class="block font-bold text-lg">₹4500</span>
                                            <span class="block text-xs text-slate-500">1 Year (VIP)</span>
                                        </div>
                                    </label>
                                </div>
                                @error('duration_months') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Message for the Zoo (Optional)</label>
                                <textarea name="message" rows="3" class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50 py-3" placeholder="I love this animal..."></textarea>
                            </div>

                            <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-sm text-amber-800">This is a simulated transaction. No real money will be charged.</p>
                            </div>

                            <button type="submit" class="w-full bg-primary-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-primary-700 transition-colors focus:ring-4 focus:ring-primary-500/30">
                                Complete Adoption
                            </button>
                        </div>
                    </form>
                    </form>
            </div>
        </div>
        
    </div>
</div>
@endsection
