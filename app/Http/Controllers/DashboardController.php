<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Application;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalPets     = Pet::count();
        $available     = Pet::where('status', 'Available')->count();
        $adopted       = Pet::where('status', 'Adopted')->count();
        $archived      = Pet::where('status', 'Archived')->count();
        $recentPets    = Pet::with('category')->where('status', 'Available')->latest()->take(5)->get();

        // Adopter-specific stats
        $pendingCount  = auth()->user()->applications()->pending()->count();
        $approvedCount = auth()->user()->applications()->approved()->count();
        $availablePets = Pet::where('status', 'Available')->count();

        return view('dashboard', compact(
            'totalPets', 'available', 'adopted', 'archived', 'recentPets',
            'pendingCount', 'approvedCount', 'availablePets'
        ));
    }
}
