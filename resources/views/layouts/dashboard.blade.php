<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $stats = [
            'total_residents' => Resident::count(),
            'total_males' => Resident::where('gender', 'Male')->count(),
            'total_females' => Resident::where('gender', 'Female')->count(),
            'total_families' => Resident::where('is_head_of_family', true)->count(),
        ];
        
        $recentResidents = Resident::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentResidents'));
    }

    public function officialDashboard()
    {
        $stats = [
            'total_residents' => Resident::count(),
            'total_males' => Resident::where('gender', 'Male')->count(),
            'total_females' => Resident::where('gender', 'Female')->count(),
            'total_families' => Resident::where('is_head_of_family', true)->count(),
        ];
        
        $recentResidents = Resident::latest()->take(5)->get();
        
        return view('official.dashboard', compact('stats', 'recentResidents'));
    }
}