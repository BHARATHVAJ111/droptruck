<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverDetail;
use App\Models\Rate;
use App\Models\Indent;
use App\Models\Supplier;
use Illuminate\Support\Facades\Session;
use App\Models\SupplierAdvance;
use App\Models\CustomerRate;
use App\Models\TruckType;

class TripController extends Controller
{
    public function confirmedTrips()
    {
        $user = Auth::user();
        $confirmedTrips = collect();
        $filteredTrips = collect();
        $confirmationCount = 0;

        if ($user->role_id === 4) { //Updated by Thamayanthi due to display the details on Supplier
            $confirmedTrips = Indent::whereHas('indentRate', function ($query) use ($user) {
                $query->where('rates.user_id', $user->id);
                $query->where('is_confirmed_rate', 1);
                $query->where('status', '1');
            })->with('driverDetails')->with('indentRate')->latest()->orderBy('id', 'desc')->paginate(5);
            
            $filteredTrips = $confirmedTrips->filter(function ($trip) {
                return $trip->driverDetails !== null && count($trip->driverDetails) > 0;
            });
        } elseif($user->role_id === 3) {
            $confirmedTrips = Indent::with('driverDetails')
                ->where('user_id', $user->id) //Updated by Thamayanthi due to display the details on Supplier
                ->where('status', '1')
                ->orderBy('id', 'desc')
                ->paginate(5);
            $filteredTrips = $confirmedTrips->filter(function ($trip) {
                return $trip->driverDetails !== null && count($trip->driverDetails) > 0;
            });
        } elseif ($user->role_id === 1 || $user->role_id === 2) {
            $confirmedTrips = Indent::with('driverDetails')->with('user')
                ->where('status', '1')
                ->orderBy('id', 'desc')
                ->paginate(5);
            $filteredTrips = $confirmedTrips->filter(function ($trip) {
                return $trip->driverDetails !== null && count($trip->driverDetails) > 0;
            });
            $confirmationCount = $confirmedTrips->count();
        }
        //print_r($confirmedTrips);
        return view('truck.truck-page')->with(compact('filteredTrips', 'confirmedTrips', 'confirmationCount'));
    }



    public function createDriver($id)
    {
        try {
            $indent = Indent::where('status', 1)->findOrFail($id);
            $user = Auth::user();
    
            $leastRates = Rate::whereHas('indent', function ($query) use ($user, $indent) {
                $query->where('pickup_location_id', $indent->pickup_location_id)
                    ->where('drop_location_id', $indent->drop_location_id);
            })->orderBy('rate', 'asc')->take(2)->pluck('rate');
            
            $secondLeastRateAmount = Rate::whereHas('indent', function ($query) use ($user, $indent) {
                $query->where('user_id', $user->id)
                    ->where('pickup_location_id', $indent->pickup_location_id)
                    ->where('drop_location_id', $indent->drop_location_id);
            })->orderBy('rate', 'asc')->skip(1)->take(1)->pluck('rate')->first();
    
            $pickupLocationId = $indent->pickup_location_id;
            $dropLocationId = $indent->drop_location_id;
            $uniqueENQNumber = $indent->getUniqueENQNumber();
            
            $suppliers = Supplier::whereHas('supplierRate', function ($query) use ($user) {
                //$query->where('rates.user_id1', $user->id);
                $query->where('rates.is_confirmed_rate', 1);
            })
            // ->whereHas('indent', function ($query) {
            //     $query->where('status', 3);
            // })
            ->with(['supplierRate', 'indentRate'])
            ->latest()
            ->get();

            $truckTypes = TruckType::all();

            //echo 'sdsdsd<pre>'; print_r($suppliers); exit;
            return view('truck.waitDriver', compact('indent', 'uniqueENQNumber', 'leastRates', 'secondLeastRateAmount', 'pickupLocationId', 'dropLocationId', 'suppliers', 'truckTypes'));
        } catch (\Exception $e) {
            Session::flash('error', 'Error updating status: ' . $e->getMessage());
    
            return redirect()->back();
        }
    }
    

    public function index()
    {
        $user = Auth::user();
        $trips = collect();

        //if ($user->role_id === 3) { 
        if ($user->role_id === 4) { //Updated by Thamayanthi due to display the details on Supplier
            // $trips = Indent::with('driverDetails')
            //     //->where('user_id', $user->id) //Updated by Thamayanthi due to display the details on Supplier
            //     ->where('status', '2')
            //     ->get();

            // $trips = Indent::whereHas('indentRate', function ($query) use ($user) {
            //         $query->where('rates.user_id', $user->id);
            //     })->with('driverDetails')->where('status', '2')->get();

            $trips = Indent::whereHas('indentRate', function ($query) use ($user) {
                $query->where('rates.user_id', $user->id);
                $query->where('is_confirmed_rate', 1);
                $query->where('status', '2');
            })->with('driverDetails')->with('indentRate')->latest()->orderBy('id', 'desc')->paginate(5);

        } elseif($user->role_id === 3) { 
            $trips = Indent::with('driverDetails')
                ->where('user_id', $user->id) //Updated by Thamayanthi due to display the details on Supplier
                ->where('status', '2')
                ->orderBy('id', 'desc')
                ->paginate(5);
        } elseif ($user->role_id === 1 || $user->role_id === 2) {
            $trips = Indent::with('driverDetails')
                ->where('status', '2')
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
        return view('truck.index')->with(compact('trips'));
    }
    public function storeDriverDetails(Request $request)
    {
        try {
            $data = $request->validate([
                'driver_name' => 'required|string',
                'driver_number' => 'required|string',
                'vehicle_number' => 'required|string',
                'driver_base_location' => 'required|string',
                //'vehicle_photo' => 'required|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                // 'rc_book' => 'required|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                // 'insurance' => 'required|image|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'vehicle_photo' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'rc_book' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'insurance' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
                'indent_id' => 'required|exists:indents,id',
                'vehicle_type' => 'required|string',
                'truck_type' => 'required|nullable',
            ]);

            $data['vehicle_photo'] = $request->file('vehicle_photo')->store('storage/uploads', 'public');
            $data['driver_license'] = $request->file('driver_license')->store('storage/uploads', 'public');
            $data['rc_book'] = $request->file('rc_book')->store('storage/uploads', 'public');
            $data['insurance'] = $request->file('insurance')->store('storage/uploads', 'public');
            $data['new_truck_type'] = $request->input('new_truck_type');

            $driverDetail = new DriverDetail($data);
            $driverDetail->save();

            $indent = Indent::findOrFail($request->input('indent_id'));
            $indent->status = 2;
            $indent->save();

            Session::flash('success', 'Driver details submitted successfully.');

            return redirect()->route('trips.index');
        } catch (\Exception $e) {
            Session::flash('error', 'Error storing driver details: ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function triploading()
    {
        $user = Auth::user();
        $suppliers = collect();
    
        //if ($user->role_id === 3) {
        if ($user->role_id === 4) {
            // $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
            //     ->whereHas('indent', function ($query) use ($user) {
            //         $query->whereIn('1status', [1, 2, 3, 4, 5]);
            //     })->whereHas('indentRate', function ($query1) use ($user) {
            //         $query1->where('rates.user_id', $user->id);
            //     })->get();
            // $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
            //         ->whereHas('indent', function ($query) use ($user) {
            //             $query->where('status', 3);
            //         })
            //         ->get();

            //  $suppliers = Supplier::whereHas('supplierRate', function ($query) use ($user) {
            //     $query->where('rates.user_id', $user->id);
            //     $query->where('rates.is_confirmed_rate', 1);
            //     $query->whereIn('status', [1, 2, 3, 4, 5]);
            // })->with('supplierRate')->with('indentRate')->latest()->get();

            //echo 'sdsd<pre>'; print_r($suppliers); exit;

            // $suppliers = Supplier::whereHas('supplierRate', function ($query) use ($user) {
            //     $query->where('rates.user_id', $user->id);
            //     $query->where('rates.is_confirmed_rate', 1);
            // });
            $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
                ->whereHas('indent', function ($query) {
                    $query->where('status', 3);
                })
            //->with(['supplierRate', 'indentRate'])
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate(5);

        } elseif($user->role_id === 3) {
            $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
                ->whereHas('indent', function ($query) use ($user) {
                    $query->where('status', 3);
                        $query->where('trip_status', 0);
                        $query->where('user_id', $user->id);
                })
                ->orderBy('id', 'desc')
                ->paginate(5);
        } elseif ($user->role_id === 1 || $user->role_id === 2) {
            $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
                ->whereHas('indent', function ($query) {
                    $query->where('status', 3);
                     $query->where('trip_status', 0);
                })
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
    
        return view('truck.loading', compact('suppliers'));
    }
    

    public function tripunloading()
    {
        $user = Auth::user();
        $suppliers = collect();
    
        if ($user->role_id === 3 || $user->role_id === 4) {
            $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
                ->whereHas('indent', function ($query) use ($user) {
                    $query->where('status', 3)->where('trip_status', 1);
                    //if($user->role_id === 3) {
                        $query->where('user_id', $user->id);
                    //}
                })
                ->orderBy('id', 'desc')
                ->paginate(5);
        } elseif ($user->role_id === 1 || $user->role_id === 2) {
            $suppliers = Supplier::with(['indent', 'indent.customerAdvances', 'indent.supplierAdvances'])
                ->whereHas('indent', function ($query) {
                    $query->where('status', 3);
                     $query->where('trip_status', 1);
                })
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
    
        return view('truck.unloading', compact('suppliers'));
    }
    


    public function viewCompletedTripDetails($id)
    {
        $indent = Indent::findOrFail($id);

        return view('truck.completetrips', compact('indent'));
    }

    public function driverDetails($id) {
        $user = Auth::user();
        $suppliers = null;
        $suppliersAdvanceAmt = null;
        $driverAmount = 0;
        $customerAmount = 0;

        $driver = DriverDetail::where('indent_id', $id)->firstOrFail();
        $driverAmount = Rate::where('indent_id',$id)->where('is_confirmed_rate', 1)->first();
        $customerAmount = CustomerRate::where('indent_id',$id)->first();
        if($user->role_id != 3) {
           
            $suppliers = Supplier::where('indent_id', $id)->firstOrFail();
           if (SupplierAdvance::where('indent_id', $id)->exists()) {
                $suppliersAdvanceAmt = SupplierAdvance::where('indent_id', $id)->first();
            } else {
               $suppliersAdvanceAmt = 0.00;
            }

            return view('truck.driver-details', compact('driver', 'suppliers', 'suppliersAdvanceAmt', 'driverAmount', 'customerAmount'));
        } else {
            return view('truck.driver-details', compact('driver', 'suppliers', 'suppliersAdvanceAmt', 'driverAmount', 'customerAmount'));
        }
    }
}
