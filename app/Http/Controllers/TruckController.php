<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\TruckType;
use App\Models\Vehicle;

class TruckController extends Controller
{
    public function createTruck()
    {
        return view('truck.create');
    }
    public function storeTruck(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required','string','max:255',Rule::unique('truck_types', 'name'),],
        ]);

        $truck = TruckType::create($validatedData);

        return response()->json([
            'id'   => $truck->id,
            'name' => $truck->name,
        ]);
    }

    public function index()
    {
        $truckType = TruckType::all();
        return view('truck.truck-type', compact('truckType'));
    }

     public function createTruckType()
    {
        return view('truck.truck-type-create');
    }
}
