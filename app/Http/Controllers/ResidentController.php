<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $residents = Resident::latest()->paginate(10);
        return view('residents.index', compact('residents'));
    }

    public function create()
    {
        $familyHeads = Resident::where('is_head_of_family', true)->get();
        return view('residents.create', compact('familyHeads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|string',
            'sitio' => 'required|string',
            'street_address' => 'required|string',
            'household_number' => 'required|string',
        ]);

        Resident::create($request->all());
        
        return redirect()->route('residents.index')->with('success', 'Resident added successfully!');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('residents.edit', compact('resident'));
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|string',
            'sitio' => 'required|string',
            'street_address' => 'required|string',
            'household_number' => 'required|string',
        ]);

        $resident->update($request->all());
        
        return redirect()->route('residents.index')->with('success', 'Resident updated successfully!');
    }

    // UPDATE PHOTO FUNCTION
    public function updatePhoto(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        if ($request->hasFile('photo')) {

            // Delete old photo
            if ($resident->photo) {
                Storage::disk('public')->delete($resident->photo);
            }
            
            // Upload new photo
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $path = $photo->storeAs('residents', $filename, 'public');

            // Save photo path
            $resident->photo = $path;
            $resident->save();
        }
        
        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();
        
        return redirect()->route('residents.index')->with('success', 'Resident deleted successfully!');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $residents = Resident::where('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('household_number', 'like', "%{$search}%")
            ->paginate(10);
        
        return view('residents.index', compact('residents'));
    }

    public function households()
    {
        $households = Resident::where('is_head_of_family', true)
            ->with('familyMembers')
            ->get();

        return view('residents.households', compact('households'));
    }
}