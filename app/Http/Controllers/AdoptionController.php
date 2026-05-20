<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Adoption;
use App\Http\Requests\AdoptAnimalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class AdoptionController extends Controller
{
    public function index()
    {
        $animals = Animal::with('species')->get();

        $myAdoptions = Auth::check()
            ? Adoption::with('animal')->where('user_id', Auth::id())->orderByDesc('created_at')->get()
            : collect();

        return view('adopt.index', compact('animals', 'myAdoptions'));
    }

    public function confirm(AdoptAnimalRequest $request)
    {
        $prices = [1 => 500, 6 => 2500, 12 => 4500];
        $amount = $prices[$request->duration_months] ?? 500;

        $adoption = Adoption::create([
            'user_id'         => Auth::id(),
            'adopter_name'    => $request->adopter_name ?? 'Guest',
            'adopter_email'   => $request->adopter_email ?? 'guest@example.com',
            'animal_id'       => $request->animal_id,
            'amount'          => $amount,
            'duration_months' => $request->duration_months,
            'message'         => $request->message,
            'status'          => 'pending',
        ]);

        return redirect()->route('adopt.payment', $adoption->id);
    }

    public function payment(Adoption $adoption)
    {
        if ($adoption->status !== 'pending') {
            return redirect()->route('adopt.index');
        }
        
        $adoption->load('animal.species');
        return view('adopt.payment', compact('adoption'));
    }

    public function processPayment(Adoption $adoption)
    {
        if ($adoption->status !== 'pending') {
            return redirect()->route('adopt.index');
        }

        $adoption->update([
            'status' => 'active',
            'adopted_at' => now(),
            'expires_at' => now()->addMonths($adoption->duration_months),
        ]);

        return redirect()->route('adopt.index')
            ->with('success', 'Payment successful! You are now a proud animal adopter 🦁')
            ->with('new_adoption_id', $adoption->id);
    }

    public function downloadCertificate(Adoption $adoption)
    {
        $adoption->load('animal');

        $pdf = Pdf::loadView('pdf.adoption-certificate', compact('adoption'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("zootopia-adoption-{$adoption->id}.pdf");
    }
}
