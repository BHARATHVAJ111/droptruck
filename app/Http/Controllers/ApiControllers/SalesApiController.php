<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Middleware\UserAccess;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Indent;
use App\Models\Rate;
use App\Models\MaterialType;
use App\Models\TruckType;
use App\Models\CancelReason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CustomerRate;

class SalesApiController extends Controller
{
    public function createIndent(Request $request)
    {
        if($request->user_type != 3) {
            return response()->json([
                'status' => 422,
                'error' => 'Invalid User Type'
            ], 422);

            exit;
        }
        $validatedData = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'number_1' => 'required|string|regex:/^[0-9]{10}$/',
            'pickup_location_id' => 'required|string',
            'drop_location_id' => 'required|string',
            'truck_type_id' => 'required|nullable|exists:truck_types,id',
            'body_type' => 'required|string|in:Open,Container',
            'weight' => 'required|string|max:50',
            'weight_unit' => 'required|string|in:kg,tons',
            'user_id' => 'required|nullable',
            'user_type' => 'required|nullable',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validatedData->errors()
            ], 422);
        }  else {
            
            $user_id=$request->user_id;
            $user=User::find($user_id);

            $data = [
                'customer_name' => $request->customer_name,
                'company_name' => $request->company_name,
                'number_1' => $request->number_1,
                'number_2' => $request->number_2,
                'source_of_lead' => $request->source_of_lead,
                'pickup_location_id' =>$request->pickup_location_id,
                'drop_location_id' => $request->drop_location_id,
                'truck_type_id' => $request->truck_type_id,
                'body_type' => $request->body_type,
                'weight' => $request->weight,
                'weight_unit' => $request->weight_unit,
                'material_type_id' => $request->material_type_id, // Make it nullable since we are handling both cases
                'pod_soft_hard_copy' => $request->pod_soft_hard_copy,
                'remarks' => $request->remarks,
            ];

            if(!$request->indent_id) {
                $indent = $user->indents()->create($data);
            } else {
                // Updating an existing indent
                $indent = $user->indents()->find($request->indent_id);
                if ($indent) {
                    $indent->update($data);
                } else {
                    return response()->json([
                        'status' => 404,
                        'error' => 'Indent not found'
                    ], 404);
                }
            }
        }

        if ($indent) {
            return response()->json([
                'status' => 200,
                'message' => 'Indent Details Updated successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went Wrong, Try Again',
            ], 500);
        }
       
    }

    public function indentList($user_type, $user_id)
    {
        
        if(!$user_type) {
            return response()->json([
                'status' => 422,
                'error' => 'Please Enter User Type'
            ], 422);

            exit;
        }

        if(!$user_id) {
            return response()->json([
                'status' => 422,
                'error' => 'Please Enter User Id'
            ], 422);

            exit;
        }

        if (($user_type != 3) && ($user_type != 4)) {
            return response()->json([
                'status' => 422,
                'error' => 'Invalid User Type'
            ], 422);
        }

        // Your normal code continues here


        if($user_type == 3) {
            $indentsData = Indent::with('indentRate')
                ->where('user_id', $user_id)
                ->get();
        }

        if($user_type == 4) {
            $user = DB::table('users')->where('id', $user_id)->first();
            $allIndents = Indent::with('indentRate')->where('is_follow_up', 0)->get();
            $indentsData = $allIndents->filter(function ($indent) use ($user) {
                return $user->role_id !== 4 || $indent->indentRate->where('user_id', $user->id)->isEmpty();
            });

            // Convert the result to an array and re-index it numerically
            $indents = array_values($indentsData->toArray());
        }

        $materialTypeIds = $indentsData->pluck('material_type_id')->unique();
        $truckTypeIds = $indentsData->pluck('truck_type_id')->unique();
        $locationIds = $indentsData->pluck('pickup_location_id')->merge($indentsData->pluck('drop_location_id'))->unique();
    
        $materialTypes = $materialTypeIds->isNotEmpty() ? MaterialType::whereIn('id', $materialTypeIds)->pluck('name') : [];
        $truckTypes = $truckTypeIds->isNotEmpty() ? TruckType::whereIn('id', $truckTypeIds)->pluck('name') : [];
        $locations = $locationIds->isNotEmpty() ? Location::whereIn('id', $locationIds)->pluck('district') : [];

        // Construct the response
        $indentCount = $indentsData->count();
        $selectedIndentId = $indentsData->isNotEmpty() ? $indentsData->pluck('id')->first() : null;
        $weightUnits = ['kg' => 'Kilograms', 'tons' => 'Tons'];

        if($user_type == 3) {
            $indentDetails = $indentsData;
        }

        if($user_type == 4) {
            $indentDetails = $indents;
        }

        if ($indentDetails) {
            $data = [
                'status' => 200,
                'indents' => $indentDetails,
                'indentCount' => $indentCount,
                'selectedIndentId' => $selectedIndentId,
                'weightUnits' => $weightUnits,
            ];
    
            if (!empty($materialTypes)) {
                $data['materialTypes'] = $materialTypes;
            }
    
            if (!empty($truckTypes)) {
                $data['truckTypes'] = $truckTypes;
            }
    
            if (!empty($locations)) {
                $data['locations'] = $locations;
            }
    
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 400,
                'details' => 'No Records Found for Indents'
            ];
            return response()->json($data, 400);
        }
    }

    public function destroyIndent($id)
    {

        try {
            $indent = Indent::find($id);
            $indent->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Indent deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 400,
                'message' => 'No such data found',
            ], 400);
        }
    }

    public function quotedIndent(Request $request) {
        $user_id = $request->user_id;
        $user = DB::table('users')->where('id', $user_id)->first();
        $role_id = $user->role_id;
        
        $leastRates = [];

        if (!$user) {
            $data = [
                'status' => 404,
                'message' => 'User not found'
            ];
            return response()->json($data, 404);
        }

        $role_id = $user->role_id;

        if($role_id == 3) {
            $indentsForLoggedInSupplier = Indent::whereHas('indentRate', function ($query) use ($user) {
                $query->where('is_confirmed_rate', 0);
            })->where('user_id', $user->id)->with('indentRate')->latest()->get();

            foreach ($indentsForLoggedInSupplier as $key => $indent) {

                $leastAmount = json_decode($indent->indentRate);
                $leastQuotedAmount = ($leastAmount) ? $leastAmount[$key]->rate : '';
                $secondLeastRateAmount = Rate::orderBy('rate', 'asc')->skip(1)->take(1)->value('rate');
                $leastRates[$key] = [
                    'indent_id' => $indent->id,
                    'leastRate' => $leastQuotedAmount, // Assuming `indentRate` is the name of the relationship
                    'secondLeastRateAmount' => ($secondLeastRateAmount) ? $secondLeastRateAmount : 'N/A',
                ];
            }


            if (empty($leastRates)) {
                $data = [
                    'status' => 404,
                    'details' => 'No Records Found'
                ];
                return response()->json($data, 404);
            }
            $data = [
                'status' => 200,
                'indents' => $indentsForLoggedInSupplier,
                'leastRates' => $leastRates,

                //'secondLeastRateAmounts' => $secondLeastRateAmounts,
                //'indentsData' => $indentsData, // Include the indents data
                // Include other data you want to return
            ];
        
            return response()->json($data, 200);
        }

        if($role_id == 4) {
            $indentsForLoggedInSupplier = Indent::whereHas('indentRate', function ($query) use ($user) {
                $query->where('user_id', $user->id);
                $query->where('is_confirmed_rate', 0);
            })->with('indentRate')->latest()->get();

            foreach ($indentsForLoggedInSupplier as $key => $indent) {

                $leastAmount = json_decode($indent->indentRate);
                $leastQuotedAmount = ($leastAmount) ? $leastAmount[$key]->rate : '';
                $secondLeastRateAmount = Rate::where('user_id', $user->id)->orderBy('rate', 'asc')->skip(1)->take(1)->value('rate');
                $leastRates[$key] = [
                    'indent_id' => $indent->id,
                    'leastRate' => $leastQuotedAmount, // Assuming `indentRate` is the name of the relationship
                    'secondLeastRateAmount' => ($secondLeastRateAmount) ? $secondLeastRateAmount : 'N/A',
                ];
            }


            if (empty($leastRates)) {
                $data = [
                    'status' => 404,
                    'details' => 'No Records Found'
                ];
                return response()->json($data, 404);
            }
            $data = [
                'status' => 200,
                'indents' => $indentsForLoggedInSupplier,
                'leastRates' => $leastRates,
            ];
        
            return response()->json($data, 200);
        }
    }

    public function confirmIndentDetails($user_id, $indent_id) {
        $user_id = $user_id;
        $user = DB::table('users')->where('id', $user_id)->first();
        $role_id = $user->role_id;
        
        $leastRates = [];

        if (!$user) {
            $data = [
                'status' => 404,
                'message' => 'User not found'
            ];
            return response()->json($data, 404);
        }

        $role_id = $user->role_id;
        if($role_id == 3) {
            $indent = Indent::findOrFail($indent_id);
            $salesPerson = User::findOrFail($indent->user_id)->name;
            $materialType = MaterialType::findOrFail($indent->material_type_id)->name;
            $truckType = TruckType::findOrFail($indent->truck_type_id)->name;

            $indentData = [
                'id' => $indent->id,
                'customer_name' => $indent->customer_name,
                'pickup_location' => $indent->pickup_location_id,
                'drop_location' => $indent->drop_location_id,
                'truck_type' => $truckType,
                'body_type' => $indent->body_type,
                'material_type' => $materialType,
                'sales_person' => $salesPerson
            ];

            $indentRates = Rate::whereHas('indent', function ($query) use ($user, $indent) {
                $query->where('indent_id', $indent->id);
            })->with('user')->orderBy('created_at', 'asc')->get();

            $data = [
                'status' => 200,
                'message' => 'Indent Details Fetched Successfully',
                'indent_details' => $indentData,
                'indentRates' => $indentRates
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Invalid User Details'
            ];
            return response()->json($data, 404);
        }
    }

    public function confirmDriverAmount(Request $request)
    {
        $user_id = $request->user_id;
        $user = DB::table('users')->where('id', $user_id)->first();
        $role_id = $user->role_id;
        //print_r($user); exit;
        if (!$user) {
            $data = [
                'status' => 404,
                'message' => 'User not found'
            ];
            return response()->json($data, 404);
        }

        $role_id = $user->role_id;

        if($role_id == 3) {
            $validatedData = Validator::make($request->all(), [
                'indent_id' => 'required',
                'rate_id' => 'required',
                'user_id' => 'required',
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validatedData->errors()
                ], 422);
            }
            
            $indent = Indent::where('id', $request->indent_id)->first();

            //Get Selected Rate Amount
            $rateAmount = Rate::where('id', $request->rate_id)->first();

            //$indent->status = '1';
            $indent->driver_rate = ($rateAmount) ? $rateAmount->rate : '0.00'; //Selected Driver Amount
            $indent->driver_rate_id = $request->rate_id;

            if($indent->save()) {
                 $data = [
                    'status' => 200,
                    'message' => 'Driver Rate Updated Successfully',
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    'status' => 200,
                    'message' => 'Indent Details Fetched Successfully',
                ];
                return response()->json($data, 200);
            }
           
        } else {
            $data = [
                'status' => 404,
                'message' => 'Invalid User Details'
            ];
            return response()->json($data, 404);
        }
    
    }

    public function confirmCustomerAmount(Request $request, $roleId) {
        if($roleId == 3) {
            $validatedData = Validator::make($request->all(), [
                'indent_id' => 'required',
                'rate' => 'required',
                'user_id' => 'required',
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    'status' => 422,
                    'error' => $validatedData->errors()
                ], 422);
            }

            $user_id = $request->user_id;
            $user = DB::table('users')->where('id', $user_id)->first();
            $role_id = $user->role_id;
           
            $customerRate = CustomerRate::where('indent_id', $request->indent_id)->first();
            if($customerRate) {

                    $customerRate->update([
                        'rate' => $request->input('rate'),
                    ]);
                if($customerRate) {
                    $data = [
                        'status' => 200,
                        'message' => 'Customer Rate Updated Successfully'
                    ];
                    return response()->json($data, 200);
                }
            } else {
                $customerRate = CustomerRate::create([
                    'indent_id' => $request->indent_id,
                    'rate' => $request->rate,
                ]);
                if($customerRate) {
                    $data = [
                        'status' => 200,
                        'message' => 'Customer Rate Created Successfully'
                    ];
                return response()->json($data, 200);
                }
                
            }
            echo 'sa asadsds'; exit;
        } else {
            $data = [
                'status' => 400,
                'message' => 'Invalid User'
            ];
            return response()->json($data, 400);
        }
    }

}
