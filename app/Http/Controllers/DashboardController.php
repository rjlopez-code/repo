<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Basic Statistics
        $totalResidents = Resident::count();
        $totalMales = Resident::where('gender', 'Male')->count();
        $totalFemales = Resident::where('gender', 'Female')->count();
        $totalHouseholds = Resident::where('is_head_of_family', true)->count();
        
        // Percentages
        $malePercentage = $totalResidents > 0 ? round(($totalMales / $totalResidents) * 100, 1) : 0;
        $femalePercentage = $totalResidents > 0 ? round(($totalFemales / $totalResidents) * 100, 1) : 0;
        $avgMembersPerHousehold = $totalHouseholds > 0 ? round($totalResidents / $totalHouseholds, 1) : 0;
        
        // Age Groups
        $ageGroups = [
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 17')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 30')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 31 AND 45')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 46 AND 60')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 60')->count(),
        ];
        
        // Civil Status Data
        $civilStatusData = [
            'Single' => Resident::where('civil_status', 'Single')->count(),
            'Married' => Resident::where('civil_status', 'Married')->count(),
            'Widowed' => Resident::where('civil_status', 'Widowed')->count(),
            'Divorced' => Resident::where('civil_status', 'Divorced')->count(),
        ];
        
        // Sitio Distribution
        $sitios = Resident::select('sitio', DB::raw('count(*) as total'))
            ->groupBy('sitio')
            ->get();
        
        $sitioLabels = $sitios->pluck('sitio')->toArray();
        $sitioData = $sitios->pluck('total')->toArray();
        
        // Recent Residents
        $recentResidents = Resident::latest()->take(5)->get();
        
        // Households
        $households = Resident::where('is_head_of_family', true)
            ->with('familyMembers')
            ->take(7)
            ->get();
        
        // Resident growth (example calculation)
        $lastMonth = Resident::where('created_at', '<', now()->subDays(30))->count();
        $residentGrowth = $lastMonth > 0 ? round((($totalResidents - $lastMonth) / $lastMonth) * 100, 1) : 0;
        
        return view('admin.dashboard', compact(
            'totalResidents',
            'totalMales', 
            'totalFemales',
            'totalHouseholds',
            'malePercentage',
            'femalePercentage',
            'avgMembersPerHousehold',
            'ageGroups',
            'civilStatusData',
            'sitioLabels',
            'sitioData',
            'recentResidents',
            'households',
            'residentGrowth'
        ));
    }

    public function officialDashboard()
    {
        $totalResidents = Resident::count();
        $totalMales = Resident::where('gender', 'Male')->count();
        $totalFemales = Resident::where('gender', 'Female')->count();
        $totalHouseholds = Resident::where('is_head_of_family', true)->count();
        
        $malePercentage = $totalResidents > 0 ? round(($totalMales / $totalResidents) * 100, 1) : 0;
        $femalePercentage = $totalResidents > 0 ? round(($totalFemales / $totalResidents) * 100, 1) : 0;
        
        $ageGroups = [
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 17')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 30')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 31 AND 45')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 46 AND 60')->count(),
            Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 60')->count(),
        ];
        
        $civilStatusData = [
            'Single' => Resident::where('civil_status', 'Single')->count(),
            'Married' => Resident::where('civil_status', 'Married')->count(),
            'Widowed' => Resident::where('civil_status', 'Widowed')->count(),
            'Divorced' => Resident::where('civil_status', 'Divorced')->count(),
        ];
        
        $recentResidents = Resident::latest()->take(5)->get();
        
        return view('official.dashboard', compact(
            'totalResidents', 'totalMales', 'totalFemales', 'totalHouseholds',
            'malePercentage', 'femalePercentage', 'ageGroups', 'civilStatusData', 'recentResidents'
        ));
    }
}