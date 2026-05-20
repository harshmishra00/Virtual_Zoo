@extends('layouts.app')

@section('title', 'Secure Payment - Zootopia')

@section('content')
<div class="bg-slate-50 min-h-screen py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-display font-bold text-slate-900 mb-4">Secure Payment</h1>
            <p class="text-slate-600">Complete your adoption securely.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
            <!-- Order Summary -->
            <div class="bg-slate-900 text-white p-8">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-slate-300">Adopting</span>
                    <span class="font-bold">{{ $adoption->animal->name }} ({{ $adoption->animal->species->name }})</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-slate-300">Adopter Name</span>
                    <span class="font-bold">{{ $adoption->adopter_name }}</span>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <span class="text-slate-300">Duration</span>
                    <span class="font-bold">{{ $adoption->duration_months }} Months</span>
                </div>
                <div class="border-t border-slate-700 pt-4 flex justify-between items-center">
                    <span class="text-lg">Total Amount</span>
                    <span class="text-3xl font-display font-bold text-primary-400">₹{{ number_format($adoption->amount, 0) }}</span>
                </div>
            </div>

            <!-- Fake Payment Form -->
            <div class="p-8 md:p-10">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex items-start gap-3">
                    <svg class="w-6 h-6 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <h4 class="font-bold text-amber-800">Test Environment</h4>
                        <p class="text-sm text-amber-700 mt-1">This is a simulated payment gateway. No real transaction will occur. Just click the button below to complete the payment.</p>
                    </div>
                </div>

                <form action="{{ route('adopt.process-payment', $adoption->id) }}" method="POST" x-data="{ processing: false }" @submit="processing = true">
                    @csrf
                    
                    <div class="space-y-4 mb-8 opacity-50 pointer-events-none">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Card Number</label>
                            <input type="text" value="**** **** **** 4242" class="w-full rounded-xl border-slate-300 bg-slate-100" readonly>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Expiry Date</label>
                                <input type="text" value="12/28" class="w-full rounded-xl border-slate-300 bg-slate-100" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">CVV</label>
                                <input type="text" value="***" class="w-full rounded-xl border-slate-300 bg-slate-100" readonly>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary-600 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-primary-700 transition-colors focus:ring-4 focus:ring-primary-500/30 flex justify-center items-center gap-2" :class="{ 'opacity-75 cursor-not-allowed': processing }">
                        <svg x-show="processing" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="processing ? 'Processing Payment...' : 'Pay ₹{{ number_format($adoption->amount, 0) }} Now'"></span>
                    </button>
                    
                    <div class="text-center mt-6">
                        <a href="{{ route('adopt.index') }}" class="text-sm text-slate-500 hover:text-slate-800 transition">Cancel and return to adoption page</a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection
