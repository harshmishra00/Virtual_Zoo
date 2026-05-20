<div>
    @if(session('review_success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-start gap-3 mb-6">
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>{{ session('review_success') }}</div>
        </div>
    @else
        <form wire:submit="submit" class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Write a Review</h3>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Rating</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" wire:click="$set('rating', {{ $i }})" class="focus:outline-none transition-transform hover:scale-110">
                            <svg class="w-8 h-8 {{ $rating >= $i ? 'text-accent-500' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    @endfor
                </div>
                @error('rating') <span class="text-danger-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                <input wire:model="title" type="text" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Summarize your experience">
                @error('title') <span class="text-danger-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-1">Review</label>
                <textarea wire:model="body" rows="4" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Tell us what you learned or enjoyed about this animal..."></textarea>
                @error('body') <span class="text-danger-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                <span wire:loading.remove wire:target="submit">Submit Review</span>
                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Submitting...
                </span>
            </button>
        </form>
    @endif
</div>
