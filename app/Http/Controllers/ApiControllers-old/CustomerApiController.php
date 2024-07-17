<?php

namespace App\Http\Controllers\ApiControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerApiController extends Controller
{
    public function indexcustomerapi()
    {
        $customers = Customer::all();

        if ($customers->count() > 0) {
            $data = [
                'status' => 200,
                'customers' => $customers,
                
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'details' => 'No Records Found'
            ];

            return response()->json($data, 404);
        }
        // return view('customers.customer', compact('customers'));
    }

    public function createcustomerapi()
    {   
        $customers = Customer::all();
        
        if ($customers->count() > 0) {
            $data = [
                'status' => 200,
                'customers' => $customers,
                
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'details' => 'No Records Found'
            ];

            return response()->json($data, 404);
        }

        // return view('customers.customer', compact('customers'));    
    }
    public function storeCustomerapi(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gst_number' => 'nullable|string|max:20',
            'lead_source' => 'nullable|string|max:255',
            'business_card.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'gst_document' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'company_name_board' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'remarks' => 'nullable|string|max:1000',

        ]);
    
        if (!$validator) {
            return response()->json([
                'status' => 422,
                'error' => $validator->errors()
            ], 422);
        } 
        else{
           
        $customer = Customer::create([
            'customer_name' => $request->get('customer_name'),
            'company_name' => $request->get('company_name'), 
            'contact_number' => $request->get('contact_number'),
            'address' => $request->get('address'),
            'gst_number' => $request->get('gst_number'),
            'lead_source' => $request->get('lead_source'),
            'remarks' => $request->get('remarks'),
            ]);
        }

    
        // $businessCardPaths = [];
        // foreach ($request->file('business_card') as $file) {
        //     $businessCardPaths[] = $file->store('businesscard', 'public');
        // }
        // $gstDocumentPath = $request->file('gst_document')->store('gstdocument', 'public');
        // $companyBoardPath = $request->file('company_name_board')->store('companyboard', 'public');
    
        // $customer->business_card = json_encode($businessCardPaths);
        // $customer->gst_document = $gstDocumentPath;
        // $customer->company_name_board = $companyBoardPath;
    
        // $customer->save();
        if ($customer) {
            return response()->json([
                'status' => 200,
                'message' => 'data insert successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'data not insert successfully',
            ], 500);
        }
    
        // return response()->json(['success' => 'Customer created/updated successfully'], 200);
    }
    
    
    
        
    
        

    public function showcustomerapi($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer->count() > 0) {
            $data = [
                'status' => 200,
                'customers' => $customer,
                
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'details' => 'No Records Found'
            ];

            return response()->json($data, 404);
        }
        // return view('customers.view', compact('customer'));
    }
    
    

    public function editcustomerapi(Customer $customer)
    {
        if ($customer->count() > 0) {
            $data = [
                'status' => 200,
                'customers' => $customer,
                
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'details' => 'No Records Found'
            ];

            return response()->json($data, 404);
        }
        // return view('customers.edit', compact('customer'));
    }

    public function updateCustomerapi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gst_number' => 'nullable|string|max:20',
            'lead_source' => 'nullable|string|max:255',
            'business_card.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'gst_document' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'company_name_board' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'remarks' => 'nullable|string|max:1000',

        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->errors(),
            ], 422);
        } 
        else{
            $customer = Customer::find($id);
            if($customer){
                $customer->update([
                   'customer_name' => $request->get('customer_name'),
                   'company_name' => $request->get('company_name'), 
                   'contact_number' => $request->get('contact_number'),
                   'address' => $request->get('address'),
                   'gst_number' => $request->get('gst_number'),
                   'lead_source' => $request->get('lead_source'),
                   'remarks' => $request->get('remarks'),
                   ]);
                   return response()->json([
                    'status' => 200,
                    'message' => 'data update successfully',
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'no such file in directory',
                ], 500);
            }
       

      
      

    if ($request->hasFile('business_card')) {
        $businessCardPaths = [];
        foreach ($request->file('business_card') as $file) {
            $businessCardPaths[] = $file->store('businesscard', 'public');
        }
        $customer->business_card = json_encode($businessCardPaths);
    }
        if ($request->hasFile('gst_document')) {
            $gstDocumentPath = $request->file('gst_document')->store('gstdocument', 'public');
            $customer->gst_document = $gstDocumentPath;
        }
        if ($request->hasFile('company_name_board')) {
            $companyBoardPath = $request->file('company_name_board')->store('companyboard', 'public');
            $customer->company_name_board = $companyBoardPath;
        }
        $customer->save();
    }
    
        // return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }
    
    
    public function destroycustomerapi($id)
    {
        $customer = Customer::findOrFail($id);
        

        if($customer){
            $customer->delete();
              return response()->json([
                    'status' => 200,
                    'message' => 'data Deleted successfully',
                ], 200);

        }else{
            return response()->json([
                'status'=>404,
                'message'=>'not such a id file here'
            ],404);
        }
    
        // return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
    
}

