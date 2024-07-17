<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pricing;
use Illuminate\Validation\Rule;

class PricingController extends Controller
{
    public $cities = [
        'Ariyalur', 'Chengalpattu', 'Chennai', 'Coimbatore', 'Cuddalore', 'Dharmapuri', 'Dindigul',
        'Erode', 'Kallakurichi', 'Kancheepuram', 'Karur', 'Krishnagiri', 'Madurai', 'Mayiladuthurai',
        'Nagapattinam', 'Kanniyakumari', 'Namakkal', 'Perambalur', 'Pudukottai', 'Ramanathapuram',
        'Ranipet', 'Salem', 'Sivagangai', 'Tenkasi', 'Thanjavur', 'Theni', 'Thiruvallur', 'Thiruvarur',
        'Thoothukudi', 'Trichirappalli', 'Tirunelveli', 'Tirupathur', 'Tiruppur', 'Tiruvannamalai',
        'The Nilgiris', 'Vellore', 'Viluppuram', 'Virudhunagar'
    ];

    public function index()
    {
        $pricings = Pricing::all();
        $cities = $this->cities; 
        return view('pricing.pricing', compact('pricings', 'cities'));
    }

    public function create()
    {
        $pricings = Pricing::paginate(20);
        $cities = $this->cities; 
        return view('pricing.pricing', compact('pricings', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_city' => ['required', Rule::in($this->cities)],
            'drop_city' => ['required', Rule::in($this->cities)],
            'vehicle_type' => 'required|string|in:TATA ACE,ASHOK LEYLAND DOST,MAHINDRA BOLERO PICK UP,ASHOK LEYLAND BADA DOST,TATA 407,EICHER 14 FEET,EICHER 17 FEET,EICHER 19 FEET,TATA 22 FEET,TATA TRUCK (6 TYRE),TAURUS 16 T (10 TYRE),TAURUS 21 T (12 TYRE),TAURUS 25 T (14 TYRE),CONTAINER 20 FT,CONTAINER 32 FT SXL,CONTAINER 32 FT MXL,CONTAINER 32 FT SXL / MXL HQ,20 FEET OPEN ALL SIDE (ODC),28-32 FEET OPEN-TRAILOR JCB ODC,32 FEET OPEN-TRAILOR ODC,40 FEET OPEN-TRAILOR ODC',
            'body_type' => 'required|string|in:Open,Container',
            'rate_from' => 'required|numeric|min:0',
            'rate_to' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:1000',
        ]);

        Pricing::create($request->all());
        return redirect()->route('pricings.index')->with('success', 'Pricing added successfully');
    }

    public function edit($id)
    {
        $pricing = Pricing::findOrFail($id);
        $cities = $this->cities; 
        return view('pricing.pricing', compact('pricing', 'cities'));
    }
    
    public function update(Request $request, $id)
    {
        $pricing = Pricing::findOrFail($id);
    
        $request->validate([
            'pickup_city' => ['required', Rule::in($this->cities)],
            'drop_city' => ['required', Rule::in($this->cities)],
            'vehicle_type' => 'required|string|in:TATA ACE,ASHOK LEYLAND DOST,MAHINDRA BOLERO PICK UP,ASHOK LEYLAND BADA DOST,TATA 407,EICHER 14 FEET,EICHER 17 FEET,EICHER 19 FEET,TATA 22 FEET,TATA TRUCK (6 TYRE),TAURUS 16 T (10 TYRE),TAURUS 21 T (12 TYRE),TAURUS 25 T (14 TYRE),CONTAINER 20 FT,CONTAINER 32 FT SXL,CONTAINER 32 FT MXL,CONTAINER 32 FT SXL / MXL HQ,20 FEET OPEN ALL SIDE (ODC),28-32 FEET OPEN-TRAILOR JCB ODC,32 FEET OPEN-TRAILOR ODC,40 FEET OPEN-TRAILOR ODC',
            'body_type' => 'required|string|in:Open,Container',
            'rate_from' => 'required|numeric|min:0',
            'rate_to' => 'required|numeric|min:0',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $pricing->pickup_city = $request->input('pickup_city');
        $pricing->drop_city = $request->input('drop_city');
        $pricing->vehicle_type = $request->input('vehicle_type');
        $pricing->body_type = $request->input('body_type');
        $pricing->rate_from = $request->input('rate_from');
        $pricing->rate_to = $request->input('rate_to');
        $pricing->remarks = $request->input('remarks');
        $pricing->save();
    
        return redirect()->route('pricings.index')->with('success', 'Pricing updated successfully');
    }
    
    
    
    public function destroy($id)
    {
        $pricing = Pricing::findOrFail($id);
        $pricing->delete();
        return redirect()->route('pricings.index')->with('success', 'Pricing deleted successfully');
    }
    
    public function show(Pricing $pricing)
    {
        $cities = $this->cities; 
        return view('pricing.show', compact('pricing', 'cities'));
    }
}
