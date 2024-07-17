@extends('layouts.sidebar')

@section('content')
<style type="text/css">
    .section {
            width: 50%; /* Each section takes half of the width */
            float: left; /* Float the sections to make them appear side by side */
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
            padding: 20px; /* Add some padding for spacing */
        }
</style>
<div>
            <h2 class="btn btn-primary text-white fw-bolder float-end mt-1">User : {{ auth()->user()->name }}</h2>
        </div>
<div class="main mb-4 mt-1">
    <div class="row align-items-center">
        <div class="col">
            <div class="d-flex">
                <button type="button" class="btn dash1"  style="margin-left:600px">
                @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 1 ||auth()->user()->role_id == 2)
                <a href="{{ route('loading') }}" class="text-decoration-none text-dark"> Back</a>
                @else
                <a href="/trips" class="text-decoration-none text-dark"> Back</a>
                @endif
            </button>
            </div>
        </div>
   
        <div class="col-lg-12 mt-5" style="background-color:#D9D9D9">
                <div class="section">
                    <h3>Driver Information</h3>
                    <ul class="list-unstyled">
                        <li class="row">
                            <strong class="col-sm-3">Driver Name</strong>
                            <span class="col-sm-7">{{ $driver->driver_name }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Driver Number</strong>
                            <span class="col-sm-7">{{ $driver->driver_number }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Driver Rate</strong>
                            <span class="col-sm-7">
                                {{ $driverAmount->rate }}
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Customer Rate</strong>
                            <span class="col-sm-7">
                                {{ $customerAmount->rate }}
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Vehicle Number</strong>
                            <span class="col-sm-7">{{ $driver->vehicle_number }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Vehicle Photo</strong>
                            <span class="col-sm-7">
                                <a href="{{ asset('/' . $driver->vehicle_photo) }}" target="_blank" class="text-decoration-underline">
                                    Vehicle Photo
                                </a>
                                <a href="{{ asset('/' . $driver->vehicle_photo) }}" download="{{ asset('/' . $driver->vehicle_photo) }}">
                                    <i class="fas fa-download"></i>
                                </a><br>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Driver License</strong>
                            <span class="col-sm-7">
                                <a href="{{ asset('/' . $driver->driver_license) }}" target="_blank" class="text-decoration-underline">
                                    Driver License
                                </a>
                                <a href="{{ asset('/' . $driver->driver_license) }}" download="{{ asset('/' . $driver->driver_license) }}">
                                    <i class="fas fa-download"></i>
                                </a>
                                <br>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">RC Book</strong>
                            <span class="col-sm-7">
                                <a href="{{ asset('/' . $driver->rc_book) }}" target="_blank" class="text-decoration-underline">
                                    RC Book
                                </a>
                                <a href="{{ asset('/' . $driver->rc_book) }}" download="{{ asset('/' . $driver->rc_book) }}">
                                    <i class="fas fa-download"></i>
                                </a><br>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Insurance</strong>
                            <span class="col-sm-7">
                                <a href="{{ asset('/' . $driver->insurance) }}" target="_blank" class="text-decoration-underline">
                                    Insurance
                                </a>
                                <a href="{{ asset('/' . $driver->insurance) }}" download="{{ asset('/' . $driver->insurance) }}">
                                    <i class="fas fa-download"></i>
                                </a><br>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Tracking Link</strong>
                            <span class="col-sm-7">
                                <a href="" target="_blank" class="text-decoration-underline">
                                    Tracking
                                </a>
                            </span>
                        </li>
                    </ul>
                </div>
               @if($suppliers)
                <div class="section">
                    <h3>Vendor Information</h3>
                    <ul class="list-unstyled" style="margin: 0; padding: 0;">
                        <li class="row">
                            <strong class="col-sm-3">Vendor Name</strong>
                            <span class="col-sm-7">{{ $suppliers->supplier_name }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Vendor Number</strong>
                            <span class="col-sm-7">{{ $suppliers->contact_number }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Vendor Type</strong>
                            <span class="col-sm-7">{{ $suppliers->supplier_type }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Company Name</strong>
                            <span class="col-sm-7">{{ $suppliers->company_name }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Bank Name</strong>
                            <span class="col-sm-7">{{ $suppliers->bank_name }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">IFSC Code</strong>
                            <span class="col-sm-7">{{ $suppliers->ifsc_code }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Account Number</strong>
                            <span class="col-sm-7">{{ $suppliers->account_number }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Pan Card Number</strong>
                            <span class="col-sm-7">{{ $suppliers->pan_card_number }}</span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Pancard</strong>
                            <span class="col-sm-7">
                                <a href="{{ asset('/' . $suppliers->pan_card) }}" target="_blank" class="text-decoration-underline">
                                    Pancard
                                </a>
                                <a href="{{ asset('/' . $suppliers->pan_card) }}" download="{{ asset('/' . $suppliers->pan_card) }}">
                                    <i class="fas fa-download"></i>
                                </a><br>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Bank Details</strong>
                            <span class="col-sm-7">
                                @php
                                    $bankDetails = preg_replace('/[^a-zA-Z0-9\-\/.]/', '', $suppliers->bank_details);
                                @endphp
                                @if($suppliers->bank_details) 
                                    <a href="{{ asset('/' . $bankDetails) }}" target="_blank" class="text-decoration-underline">
                                        Bank Details
                                    </a>
                                    <a href="{{ asset('/' . $bankDetails) }}" download="{{ asset('/' . $bankDetails) }}">
                                        <i class="fas fa-download"></i>
                                    </a><br>
                                @endif
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Business Card</strong>
                            <span class="col-sm-7">
                                <!--Added by Luqman-->
                                @php
                                    $businessCardURL = preg_replace('/[^a-zA-Z0-9\-\/.]/', '', $suppliers->business_card);
                                @endphp
                                <a href="{{ asset('/' . $businessCardURL) }}" target="_blank" class="text-decoration-underline">
                                    Business Card
                                </a>
                                <a href="{{ asset('/' . $businessCardURL) }}" download="{{ asset('/' . $businessCardURL) }}">
                                    <i class="fas fa-download"></i>
                                </a><br>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Others</strong>
                            <span class="col-sm-7">
                                @php
                                    $others = preg_replace('/[^a-zA-Z0-9\-\/.]/', '', $suppliers->memo);
                                @endphp
                                @if($suppliers->memo) 
                                    <a href="{{ asset('/' . $others) }}" target="_blank" class="text-decoration-underline">
                                        Others
                                    </a>
                                    <a href="{{ asset('/' . $others) }}" download="{{ asset('/' . $others) }}">
                                        <i class="fas fa-download"></i>
                                    </a><br>
                                @endif
                            </span>
                        </li>
                         <li class="row">
                            <strong class="col-sm-3">Tracking Link</strong>
                            <span class="col-sm-7">
                                <a href="" target="_blank" class="text-decoration-underline">
                                    Tracking
                                </a>
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Eway Bill</strong>
                            <span class="col-sm-7">
                                @php
                                    $eway_bill = preg_replace('/[^a-zA-Z0-9\-\/.]/', '', $suppliers->eway_bill);
                                @endphp
                                @if($suppliers->eway_bill) 
                                    <a href="{{ asset('/' . $eway_bill) }}" target="_blank" class="text-decoration-underline">
                                        Eway Bill
                                    </a>
                                    <a href="{{ asset('/' . $eway_bill) }}" download="{{ asset('/' . $eway_bill) }}">
                                        <i class="fas fa-download"></i>
                                    </a><br>
                                @endif
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Trips Invoices</strong>
                            <span class="col-sm-7">
                                @php
                                    $trips_invoices = preg_replace('/[^a-zA-Z0-9\-\/.]/', '', $suppliers->trips_invoices);
                                @endphp
                                @if($suppliers->trips_invoices) 
                                    <a href="{{ asset('/' . $trips_invoices) }}" target="_blank" class="text-decoration-underline">
                                        Trips Invoices
                                    </a>
                                    <a href="{{ asset('/' . $trips_invoices) }}" download="{{ asset('/' . $trips_invoices) }}">
                                        <i class="fas fa-download"></i>
                                    </a><br>
                                @endif
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Other Documents</strong>
                            <span class="col-sm-7">
                                @php
                                    $other_document = preg_replace('/[^a-zA-Z0-9\-\/.]/', '', $suppliers->other_document);
                                @endphp
                                @if($suppliers->other_document) 
                                    <a href="{{ asset('/' . $other_document) }}" target="_blank" class="text-decoration-underline">
                                        Other Documents
                                    </a>
                                    <a href="{{ asset('/' . $other_document) }}" download="{{ asset('/' . $other_document) }}">
                                        <i class="fas fa-download"></i>
                                    </a><br>
                                @endif
                            </span>
                        </li>
                        <li class="row">
                            <strong class="col-sm-3">Driver Advcne paid</strong>
                            <span class="col-sm-7">
                            {{ ($suppliersAdvanceAmt != 0.00)?$suppliersAdvanceAmt->advance_amount:'00.00' }}
                            </span>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
       
    </div>
</div>

@endsection