<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function indexcustomer()
    {
        $customers = Customer::all();
        return view('customers.customer', compact('customers'));
    }

    public function createcustomer()
    {   
        $customers = Customer::paginate(15);
        return view('customers.customer', compact('customers'));    
    }
    public function storeCustomer(Request $request)
    {
        $validator = $request->validate([
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
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $businessCardPaths = [];
        foreach ($request->file('business_card') as $file) {
            $businessCardPaths[] = $file->store('businesscard', 'public');
        }
        $gstDocumentPath = $request->file('gst_document')->store('gstdocument', 'public');
        $companyBoardPath = $request->file('company_name_board')->store('companyboard', 'public');
    
        $customer = new Customer([
            'customer_name' => $request->get('customer_name'),
            'company_name' => $request->get('company_name'), 
            'contact_number' => $request->get('contact_number'),
            'address' => $request->get('address'),
            'gst_number' => $request->get('gst_number'),
            'lead_source' => $request->get('lead_source'),
            'remarks' => $request->get('remarks'),
        ]);
        $customer->business_card = json_encode($businessCardPaths);
        $customer->gst_document = $gstDocumentPath;
        $customer->company_name_board = $companyBoardPath;
    
        $customer->save();
    
        return response()->json(['success' => 'Customer created/updated successfully'], 200);
    }
    
    
    
        
    
        

    public function showcustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.view', compact('customer'));
    }
    
    

    public function editcustomer(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'business_card.*' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'gst_document' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',
            'company_name_board' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048',  
            'remarks' => 'nullable|string|max:1000',          
        ]);

        $customer = Customer::findOrFail($id);
        $customer->customer_name = $request->input('customer_name');
        $customer->company_name = $request->input('company_name'); 
        $customer->contact_number = $request->input('contact_number');
        $customer->address = $request->input('address');
        $customer->gst_number = $request->input('gst_number');
        $customer->lead_source = $request->input('lead_source');
        $customer->remarks = $request->input('remarks');

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
    
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully');
    }
    
    
    public function destroycustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
    
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
    
}
