<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Ticket;
use App\Models\Adoption;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_animals'    => Animal::count(),
            'today_bookings'   => Ticket::whereDate('created_at', today())->count(),
            'total_revenue'    => Ticket::where('status', 'confirmed')->sum('total_price'),
            'active_adoptions' => Adoption::where('status', 'active')->count(),
        ];

        $recentBookings = Ticket::with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $conservationData = Animal::selectRaw('conservation_status, COUNT(*) as count')
            ->groupBy('conservation_status')
            ->pluck('count', 'conservation_status');

        $habitatData = Animal::with('enclosure.habitat')
            ->get()
            ->groupBy(fn($a) => $a->enclosure->habitat->name ?? 'Unknown')
            ->map->count();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'conservationData', 'habitatData'));
    }
}
