@extends('layouts.admin')

@section('header', 'Users & Roles Management')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
    
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-xl font-bold text-slate-900">Registered Users</h2>
        <p class="text-sm text-slate-500 mt-1">Manage user access levels and roles across the portal.</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                    <th class="p-4 font-medium">User</th>
                    <th class="p-4 font-medium">Joined</th>
                    <th class="p-4 font-medium">Current Role</th>
                    <th class="p-4 font-medium text-right">Change Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-slate-600">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="p-4">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-purple-100 text-purple-800',
                                    'staff' => 'bg-blue-100 text-blue-800',
                                    'visitor' => 'bg-slate-100 text-slate-800',
                                ];
                                $color = $roleColors[$user->role] ?? 'bg-slate-100 text-slate-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $color }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.role', $user) }}" method="POST" class="flex justify-end gap-2">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="text-xs rounded border-slate-200 focus:ring-primary-500 focus:border-primary-500 py-1 pl-2 pr-6">
                                        @foreach(['admin', 'staff', 'visitor'] as $role)
                                            <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @else
                                <span class="text-xs text-slate-400 italic">Current User</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
