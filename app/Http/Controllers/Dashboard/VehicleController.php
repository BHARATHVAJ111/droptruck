<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\DriverDetail;
use Illuminate\Support\Facades\Storage;
use DB;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = DriverDetail::groupBy('driver_number')->get();
        return view('vehicles.vehicle', compact('vehicles'));
    }

    public function create()
    {
        //$vehicles = DriverDetail::groupBy('driver_number')->get();
        $vehicles = DB::table('driver_details as s1')
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                      ->from('driver_details as s2')
                      ->whereColumn('s2.driver_number', 's1.driver_number');
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('vehicles.vehicle', compact('vehicles'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'vehicle_number' => 'required|unique:vehicles',
        'vehicle_type' => 'required|string|in:TATA ACE,ASHOK LEYLAND DOST,MAHINDRA BOLERO PICK UP,ASHOK LEYLAND BADA DOST,TATA 407,EICHER 14 FEET,EICHER 17 FEET,EICHER 19 FEET,TATA 22 FEET,TATA TRUCK (6 TYRE),TAURUS 16 T (10 TYRE),TAURUS 21 T (12 TYRE),TAURUS 25 T (14 TYRE),CONTAINER 20 FT,CONTAINER 32 FT SXL,CONTAINER 32 FT MXL,CONTAINER 32 FT SXL / MXL HQ,20 FEET OPEN ALL SIDE (ODC),28-32 FEET OPEN-TRAILOR JCB ODC,32 FEET OPEN-TRAILOR ODC,40 FEET OPEN-TRAILOR ODC',
        'body_type' => 'required|string|in:Open,Container',
        'tonnage_passing' => 'required|numeric',
        'driver_number' => 'required',
        'status' => 'required',
        'rc_book' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        'driving_license' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
        'remarks' => 'nullable|string|max:1000',
    ]);

    $validatedData['rc_book'] = $request->file('rc_book')->store('RCbook', 'public');
    $validatedData['driving_license'] = $request->file('driving_license')->store('DrivingLicense', 'public');

    Vehicle::create($validatedData);
    
    return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully!');
}

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.view', compact('vehicle'));
    }
    
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }
    

    public function update(Request $request, Vehicle $vehicle)
    {
        $validatedData = $request->validate([
            'vehicle_number' => 'required|unique:vehicles,vehicle_number,'.$vehicle->id,
            'vehicle_type' => 'required|string|in:TATA ACE,ASHOK LEYLAND DOST,MAHINDRA BOLERO PICK UP,ASHOK LEYLAND BADA DOST,TATA 407,EICHER 14 FEET,EICHER 17 FEET,EICHER 19 FEET,TATA 22 FEET,TATA TRUCK (6 TYRE),TAURUS 16 T (10 TYRE),TAURUS 21 T (12 TYRE),TAURUS 25 T (14 TYRE),CONTAINER 20 FT,CONTAINER 32 FT SXL,CONTAINER 32 FT MXL,CONTAINER 32 FT SXL / MXL HQ,20 FEET OPEN ALL SIDE (ODC),28-32 FEET OPEN-TRAILOR JCB ODC,32 FEET OPEN-TRAILOR ODC,40 FEET OPEN-TRAILOR ODC',
            'body_type' => 'required|string|in:Open,Container',
            'tonnage_passing' => 'required|numeric',
            'driver_number' => 'required',
            'status' => 'required',
            'rc_book' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'driving_license' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'remarks' => 'nullable|string|max:1000',
        ]);
        if ($request->file('rc_book')) {
            $validatedData['rc_book'] = $request->file('rc_book')->store('RCbook', 'public');
        }   
        if ($request->file('driving_license')) {
            $validatedData['driving_license'] = $request->file('driving_license')->store('DrivingLicense', 'public');
        }
        $vehicle->update($validatedData);
        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully!');
    }
     
public function destroy(Vehicle $vehicle)
{
    Storage::delete([$vehicle->rc_book, $vehicle->driving_license]);
    $vehicle->delete();
    return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully!');
}

}
