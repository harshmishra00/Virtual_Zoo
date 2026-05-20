<div>
    <!-- Filters & Search Bar -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <!-- Search -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-3 border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors sm:text-sm" placeholder="Search animals by name...">
            </div>
            
            <div class="flex gap-2">
                <button wire:click="clearFilters" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium transition-colors">
                    Clear
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Species Class -->
            <select wire:model.live="class" class="block w-full pl-3 pr-10 py-2.5 text-sm border-slate-200 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl">
                <option value="">Any Species Class</option>
                @foreach($species as $s)
                    <option value="{{ $s->class }}">{{ ucfirst($s->class) }}</option>
                @endforeach
            </select>

            <!-- Habitat -->
            <select wire:model.live="habitat" class="block w-full pl-3 pr-10 py-2.5 text-sm border-slate-200 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl">
                <option value="">Any Habitat</option>
                @foreach($habitats as $h)
                    <option value="{{ $h->id }}">{{ $h->name }}</option>
                @endforeach
            </select>

            <!-- Conservation Status -->
            <select wire:model.live="status" class="block w-full pl-3 pr-10 py-2.5 text-sm border-slate-200 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl">
                <option value="">Any Status</option>
                @foreach($statuses as $st)
                    <option value="{{ $st }}">{{ $st }}</option>
                @endforeach
            </select>

            <!-- Diet -->
            <select wire:model.live="diet" class="block w-full pl-3 pr-10 py-2.5 text-sm border-slate-200 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl">
                <option value="">Any Diet</option>
                @foreach($diets as $d)
                    <option value="{{ $d }}">{{ $d }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading.delay class="w-full text-center py-12">
        <svg class="animate-spin h-8 w-8 text-primary-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="mt-4 text-slate-500 font-medium">Searching our zoo...</p>
    </div>

    <!-- Grid -->
    <div wire:loading.remove.delay class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($animals as $animal)
            <a href="{{ route('animals.show', $animal) }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col">
                <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
                    @if($animal->thumbnail)
                        <img src="{{ asset('storage/' . $animal->thumbnail) }}" alt="{{ $animal->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wider font-bold border @badgeColor($animal->conservation_status) backdrop-blur-md bg-white/90">
                            {{ $animal->conservation_status }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5 flex-1 flex flex-col">
                    <div class="text-xs font-bold uppercase tracking-wider text-primary-600 mb-1">{{ $animal->species->name }}</div>
                    <h3 class="text-xl font-display font-bold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $animal->name }}</h3>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2 flex-1">{{ $animal->description }}</p>
                    
                    <div class="flex items-center gap-2 text-xs font-medium text-slate-500 bg-slate-50 p-2.5 rounded-lg border border-slate-100">
                        <svg class="w-4 h-4 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="truncate">{{ $animal->enclosure->habitat->name ?? 'Unknown Habitat' }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-slate-200">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <h3 class="text-lg font-bold text-slate-900">No animals found</h3>
                <p class="text-slate-500 mt-1">Try adjusting your filters to find what you're looking for.</p>
                <button wire:click="clearFilters" class="mt-6 px-6 py-2 bg-primary-50 text-primary-700 font-medium rounded-full hover:bg-primary-100 transition-colors">Clear all filters</button>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($animals->hasPages())
        <div class="mt-10">
            {{ $animals->links() }}
        </div>
    @endif
</div>
