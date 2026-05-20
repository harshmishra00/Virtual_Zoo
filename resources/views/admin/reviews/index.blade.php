@extends('layouts.admin')

@section('header', 'Reviews Moderation')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
    
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-xl font-bold text-slate-900">Pending & Approved Reviews</h2>
        <p class="text-sm text-slate-500 mt-1">Review visitor feedback before it appears on the public animal profiles.</p>
    </div>

    <div class="divide-y divide-slate-100">
        @forelse($reviews as $review)
            <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row gap-6">
                
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                        <div class="flex text-accent-500">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-accent-500' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            @endfor
                        </div>
                        <span class="text-sm font-medium text-slate-500">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $review->title }}</h3>
                    <p class="text-slate-600 text-sm mb-3">"{{ $review->body }}"</p>
                    
                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-slate-500">By: <span class="font-medium text-slate-900">{{ $review->user->name }}</span></span>
                        <span class="text-slate-500">Animal: <a href="{{ route('animals.show', $review->animal) }}" target="_blank" class="font-medium text-primary-600 hover:underline">{{ $review->animal->name }}</a></span>
                    </div>
                </div>

                <div class="shrink-0 flex md:flex-col gap-2 justify-center">
                    @if(!$review->is_approved)
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full md:w-auto px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                                Approve
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full md:w-auto px-4 py-2 border border-red-200 text-red-600 bg-red-50 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-slate-500">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>No reviews found.</p>
            </div>
        @endforelse
    </div>
    
    @if($reviews->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
