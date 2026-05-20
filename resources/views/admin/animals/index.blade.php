@extends('layouts.admin')

@section('header', 'Animal Management')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
    
    <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-xl font-bold text-slate-900">All Animals</h2>
        <a href="{{ route('admin.animals.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Animal
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                    <th class="p-4 font-medium">Animal</th>
                    <th class="p-4 font-medium">Species</th>
                    <th class="p-4 font-medium">Enclosure</th>
                    <th class="p-4 font-medium">Status</th>
                    <th class="p-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($animals as $animal)
                    <tr class="hover:bg-slate-50 transition-colors {{ $animal->trashed() ? 'opacity-50 bg-slate-100' : '' }}">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($animal->thumbnail)
                                    <img src="{{ asset('storage/' . $animal->thumbnail) }}" class="w-10 h-10 rounded-lg object-cover bg-slate-100">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-slate-900">{{ $animal->name }}</div>
                                    <div class="text-xs text-slate-500">Age: {{ $animal->age ?? 'Unknown' }} | {{ ucfirst($animal->gender) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-slate-600">{{ $animal->species->name }}</td>
                        <td class="p-4 text-sm text-slate-600">{{ $animal->enclosure->name }}</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium border @badgeColor($animal->conservation_status)">
                                {{ $animal->conservation_status }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($animal->trashed())
                                    <form action="{{ route('admin.animals.restore', $animal->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm font-medium text-green-600 hover:text-green-900">Restore</button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.animals.edit', $animal) }}" class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.animals.destroy', $animal) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete {{ $animal->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500">No animals found in the database.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($animals->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $animals->links() }}
        </div>
    @endif
</div>
@endsection
