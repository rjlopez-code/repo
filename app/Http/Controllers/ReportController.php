<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function populationStats()
    {
        $totalResidents = Resident::count();
        $males = Resident::where('gender', 'Male')->count();
        $females = Resident::where('gender', 'Female')->count();
        
        $ageGroups = [
            '0-17' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 17')->count(),
            '18-30' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 30')->count(),
            '31-45' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 31 AND 45')->count(),
            '46-60' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 46 AND 60')->count(),
            '60+' => Resident::whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 60')->count(),
        ];
        
        $civilStatus = [
            'Single' => Resident::where('civil_status', 'Single')->count(),
            'Married' => Resident::where('civil_status', 'Married')->count(),
            'Divorced' => Resident::where('civil_status', 'Divorced')->count(),
            'Widowed' => Resident::where('civil_status', 'Widowed')->count(),
        ];
        
        $sitios = Resident::select('sitio')->distinct()->get()->map(function($sitio) {
            return [
                'name' => $sitio->sitio,
                'count' => Resident::where('sitio', $sitio->sitio)->count()
            ];
        });
        
        return view('reports.population', compact('totalResidents', 'males', 'females', 'ageGroups', 'civilStatus', 'sitios'));
    }
    
    public function exportPDF()
    {
        $residents = Resident::all();
        $pdf = Pdf::loadView('reports.pdf', compact('residents'));
        return $pdf->download('barangay-residents-report.pdf');
    }
}