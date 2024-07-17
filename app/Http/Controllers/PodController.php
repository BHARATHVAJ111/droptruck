<?php

// app/Http/Controllers/PodController.php

namespace App\Http\Controllers;

use App\Models\Pod;
use App\Models\Indent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class PodController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pods = collect();
    
        if ($user->role_id === 3) {
            $pods = Pod::whereHas('indent', function ($query) use ($user) {
                    $query->where('status', 6)
                          ->where('user_id', $user->id);
                })
                ->orderBy('id', 'desc')
                ->paginate(5);
        } elseif ($user->role_id === 1 || $user->role_id === 2) {
            $pods = Pod::whereHas('indent', function ($query) {
                    $query->where('status', 6);
                })
                ->orderBy('id', 'desc')
                ->paginate(5);
        }
    
        return view('pod.index', compact('pods'));
    }
    
    public function create($id)
    {
        $indent = Indent::findOrFail($id); // Replace $indentId with the actual ID you want to find
        
        return view('pod.create', compact('indent'));
    }
    

    public function store(Request $request)
    {
        $submitWithData = $request->has('submit_with_data');
        $submitWithoutData = $request->has('submit_without_data');
    
        // If both buttons are clicked or none of them are clicked
        if ($submitWithData && $submitWithoutData || !$submitWithData && !$submitWithoutData) {
            return redirect()->back()->with('error', 'Please choose one option');
        }
    
        // If the "Submit without Data" button is clicked
        if ($submitWithoutData) {
            // Simply save the POD without validating and processing other fields
            $pod = new Pod();
            $pod->indent_id = $request->input('indent_id');
            $pod->save();
    
            // Find the associated Indent and update its status
            $indent = Indent::find($request->input('indent_id'));
            if ($indent) {
                $indent->status = 6;  // Or whatever status you want to set
                $indent->save();
            }
    
            return redirect()->route('pods.index')->with('success', 'POD created successfully without data');
        }
    
        // If the "Submit with Data" button is clicked, continue with the validation and processing
        $request->validate([
            'courier_receipt_no' => 'required',
            'pod_soft_copy' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pod_courier' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'indent_id' => 'required|exists:indents,id',
        ]);
    
        // Create a new POD instance with validated data
        $pod = new Pod([
            'courier_receipt_no' => $request->get('courier_receipt_no'),
        ]);
    
        // Associate the Pod with the Indent
        $pod->indent()->associate($request->input('indent_id'));
    
        // Handle soft copy file upload
        if ($request->hasFile('pod_soft_copy')) {
            $podSoftCopyPath = $request->file('pod_soft_copy')->store('pod_soft_copies', 'public');
            $pod->pod_soft_copy = $podSoftCopyPath;
        }
    
        // Handle courier file upload
        if ($request->hasFile('pod_courier')) {
            $podCourier = $request->file('pod_courier')->store('pod_courier', 'public');
            $pod->pod_courier = $podCourier;
        }
    
        // Save the POD
        $pod->save();
    
        // Find the associated Indent and update its status
        $indent = Indent::find($request->input('indent_id'));
        if ($indent) {
            $indent->status = 6;  // Or whatever status you want to set
            $indent->save();
        }
    
        return redirect()->route('pods.index')->with('success', 'POD created successfully');
    }
    
    
  // Edit method
public function edit($id)
{
    // Find the POD by its ID
    $pod = Pod::find($id);

    // Check if the POD exists
    if (!$pod) {
        return redirect()->route('pods.index')->with('error', 'POD not found');
    }

    // Load the corresponding indent for reference
    $indent = $pod->indent;

    // Render the edit view with the POD and indent data
    return view('pod.edit', compact('pod', 'indent'));
}

// Update method
public function update(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'courier_receipt_no' => 'required',
        'pod_soft_copy' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'pod_courier' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Find the POD by its ID
    $pod = Pod::find($id);

    // Check if the POD exists
    if (!$pod) {
        return redirect()->route('pods.index')->with('error', 'POD not found');
    }

    // Update the POD data
    $pod->courier_receipt_no = $request->input('courier_receipt_no');

    // Check if new soft copy is provided
    if ($request->hasFile('pod_soft_copy')) {
        // Delete the old file if it exists
        if ($pod->pod_soft_copy) {
            Storage::delete('public/' . $pod->pod_soft_copy);
        }

        // Store the new soft copy
        $pod->pod_soft_copy = $request->file('pod_soft_copy')->store('pod_soft_copies', 'public');
    }

    // Check if new courier is provided
    if ($request->hasFile('pod_courier')) {
        // Delete the old file if it exists
        if ($pod->pod_courier) {
            Storage::delete('public/' . $pod->pod_courier);
        }

        // Store the new courier
        $pod->pod_courier = $request->file('pod_courier')->store('pod_courier', 'public');
    }

    // Save the changes
    $pod->save();

    return redirect()->route('pods.index')->with('success', 'POD updated successfully');
}


    public function destroy(Pod $pod)
    {
        $pod->delete();

        return redirect()->route('pods.index')->with('success', 'POD deleted successfully');
    }
}
