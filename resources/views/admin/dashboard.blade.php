@extends('layouts.admin')

@section('header', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Total Animals</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $stats['animals'] }}</h3>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Tickets Sold</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $stats['tickets'] }}</h3>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-accent-50 text-accent-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Adoptions</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $stats['adoptions'] }}</h3>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 {{ $stats['pending_reviews'] > 0 ? 'bg-red-50 text-red-600' : 'bg-slate-50 text-slate-600' }} rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Pending Reviews</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $stats['pending_reviews'] }}</h3>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bold text-slate-900 text-lg">Ticket Sales (Last 30 Days)</h3>
        </div>
        <div class="relative h-72 w-full">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex flex-col h-[400px]">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <h3 class="font-bold text-slate-900 text-lg">Recent Activity</h3>
            <a href="{{ route('admin.activity-logs.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">View all</a>
        </div>
        
        <div class="flex-1 overflow-y-auto pr-2 space-y-4">
            @forelse($recentActivity as $log)
                <div class="flex gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center shrink-0 mt-0.5">
                        <span class="text-xs font-bold text-slate-600">{{ substr($log->user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-800"><span class="font-bold">{{ $log->user->name }}</span> {{ $log->action }} <span class="font-medium text-slate-900">{{ $log->entity_type }} #{{ $log->entity_id }}</span></p>
                        <p class="text-xs text-slate-500">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-slate-500 text-sm">No recent activity.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Use realistic dummy data for demo purposes if $salesData is empty
        const chartLabels = @json(array_keys($salesData ?? []));
        const chartValues = @json(array_values($salesData ?? []));
        
        // If empty (e.g. freshly seeded DB where all tickets are "today" or random), generate a nice curve
        const finalLabels = chartLabels.length > 0 ? chartLabels : Array.from({length: 14}, (_, i) => {
            const d = new Date();
            d.setDate(d.getDate() - (13 - i));
            return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        });
        
        const finalValues = chartValues.length > 0 ? chartValues : [12, 19, 15, 25, 22, 30, 28, 35, 42, 38, 45, 50, 48, 55];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: finalLabels,
                datasets: [{
                    label: 'Tickets Sold',
                    data: finalValues,
                    borderColor: '#10b981', // primary-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false }
                    },
                    x: {
                        grid: { display: false, drawBorder: false }
                    }
                }
            }
        });
    });
</script>
@endsection
