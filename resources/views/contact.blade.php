@extends('layouts.app')

@section('title', 'Contact Us - Zootopia')

@section('content')
<div class="bg-slate-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-display font-bold text-slate-900 mb-4">Get in Touch</h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto">Have questions about your visit, our animals, or conservation efforts? We're here to help.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
            
            <!-- Contact Info -->
            <div>
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm mb-8">
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-primary-50 p-3 rounded-full text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Our Network</h4>
                                <p class="text-slate-600">Cloud Data Center<br>Always Online, 24/7</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="bg-primary-50 p-3 rounded-full text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Email Support</h4>
                                <p class="text-slate-600">info@zootopia.com<br>support@zootopia.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="bg-primary-50 p-3 rounded-full text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">Technical Support</h4>
                                <p class="text-slate-600">Connection Issues: (555) 123-4567<br>Billing: (555) 987-6543</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 text-white shadow-lg">
                    <h3 class="text-xl font-bold mb-4">Server Uptime</h3>
                    <ul class="space-y-2">
                        <li class="flex justify-between border-b border-slate-700 pb-2"><span class="text-slate-300">Live Streams</span> <span class="text-green-400">24/7 Available</span></li>
                        <li class="flex justify-between border-b border-slate-700 pb-2 pt-2"><span class="text-slate-300">VR Environments</span> <span class="text-green-400">24/7 Available</span></li>
                        <li class="flex justify-between pt-2"><span class="text-slate-300">Customer Support</span> <span>9:00 AM - 5:00 PM EST</span></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xl">
                <h3 class="text-2xl font-bold text-slate-900 mb-6">Send us a Message</h3>
                
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50">
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-slate-700 mb-1">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50">
                            @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                            <textarea name="message" id="message" rows="5" required class="block w-full rounded-xl border-slate-300 focus:border-primary-500 focus:ring-primary-500 bg-slate-50">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full py-4 px-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-primary-500/30">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
