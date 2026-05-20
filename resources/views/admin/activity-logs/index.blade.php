@extends('layouts.admin')

@section('header', 'System Activity Logs')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
    
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-xl font-bold text-slate-900">Activity Logs</h2>
        <p class="text-sm text-slate-500 mt-1">Audit trail of all administrative and system actions.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                    <th class="p-4 font-medium">Timestamp</th>
                    <th class="p-4 font-medium">User</th>
                    <th class="p-4 font-medium">Action</th>
                    <th class="p-4 font-medium">Entity</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 text-sm text-slate-600 whitespace-nowrap">
                            {{ $log->created_at->format('M d, Y H:i:s') }}
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-900 text-sm">{{ $log->user->name ?? 'System' }}</div>
                        </td>
                        <td class="p-4">
                            @php
                                $actionColors = [
                                    'created' => 'bg-green-100 text-green-800',
                                    'updated' => 'bg-blue-100 text-blue-800',
                                    'deleted' => 'bg-red-100 text-red-800',
                                    'restored' => 'bg-purple-100 text-purple-800',
                                ];
                                $color = $actionColors[$log->action] ?? 'bg-slate-100 text-slate-800';
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider {{ $color }}">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-slate-900 font-medium">{{ class_basename($log->entity_type) }} #{{ $log->entity_id }}</div>
                            @if($log->details)
                                <div class="text-xs text-slate-500 truncate max-w-xs">{{ json_encode($log->details) }}</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">No activity logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
