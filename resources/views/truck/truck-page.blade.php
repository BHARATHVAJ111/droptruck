<!-- confirmation.blade.php -->

@extends('layouts.sidebar')

@section('content')
<style>
     .pagination-sm .page-link {
        font-size: 0.8rem; /* Adjust the font size */
        padding: 0.25rem 0.5rem; /* Adjust the padding */
    }

    .pagination-sm .page-item {
        margin: 0 2px; /* Adjust the margin */
    }
    .active>span {
        background-color: #F98917 !important;
        color: white;
        padding: 10px;
        /* border-radius: 15px; */
    }
    .btn-warning.custom-active {
        background: linear-gradient(135deg, #007bff, #8a2be2);
        color: #fff;
        border: #8a2be2;
    }
    .bg-gradient-info {
            background-image: radial-gradient(515px at 48.7% 52.8%, rgb(239, 110, 110) 0%, rgb(230, 25, 25) 46.5%, rgb(154, 11, 11) 100.2%);
        }
        .circle-badge {
        border-radius: 50%;
    }
</style>
<div>
        <h2 class="btn btn-primary text-white fw-bolder float-end mt-1">User : {{ auth()->user()->name }}</h2>
    </div>
<div class="mt-3">
    <div class="m-3">
        <a class="btn btn-warning custom-active" href="{{route('confirmed-trips')}}" style="font-size: 12px; padding: 5px 10px;position:relative;">Waiting for driver
        <span class="badge badge-primary circle-badge text-light" id="canceledIndentsCount" style="position: absolute; top: -10px; right: -10px; background: linear-gradient(45deg, #F31559, #F6635C);">
        {{ $confirmedTrips->count() }}
    </span>
    </a>
        <a class="btn btn-warning" href="{{route('trips.index')}}" style="font-size: 12px; padding: 5px 10px;">Loading</a>
        <a class="btn btn-warning" href="{{route('loading')}}" style="font-size: 12px; padding: 5px 10px;">On The Road</a>
        <a class="btn btn-warning" href="{{route('unloading')}}" style="font-size: 12px; padding: 5px 10px;">Unloading</a>
        <a class="btn btn-warning" href="{{route('extra_costs.index')}}" style="font-size: 12px; padding: 5px 10px;">Pod</a>
        <a class="btn btn-warning" href="{{route('pods.index')}}" style="font-size: 12px; padding: 5px 10px;">Complete Trips</a>
    </div>
</div>

<div class="card-body text-center mt-3">
<table class="table table-bordered table-striped table-hover" style="font-size:8px;">
        <thead>
            <tr>
                <th class="bg-gradient-info text-light">Enq No</th>
                @if(auth()->user()->role_id != 4)
                    <th class="bg-gradient-info text-light">Customer Name</th>
                    <th class="bg-gradient-info text-light">Company Name</th>
                    <th class="bg-gradient-info text-light">Number 1</th>
                @endif
                <th class="bg-gradient-info text-light">Pickup Location</th>
                <th class="bg-gradient-info text-light">Drop Location</th>
                <th class="bg-gradient-info text-light">Material Type</th>
                <th class="bg-gradient-info text-light">Truck Type</th>
                <th class="bg-gradient-info text-light">Body type</th>
                <th class="bg-gradient-info text-light">Weight</th>
                <th class="bg-gradient-info text-light">Driver Rate</th>
                @if(auth()->user()->role_id != 4)
                    <th class="bg-gradient-info text-light">Customer Rate</th>
                @endif
                <th class="bg-gradient-info text-light">Sales Person</th>
                <th class="bg-gradient-info text-light">Supplier Name</th>
                <th class="bg-gradient-info text-light">Created Date</th>
                <th class="bg-gradient-info text-light">Remarks</th>
            </tr>
        </thead>
        <tbody> 
            @foreach($confirmedTrips as $confirmedIndent)

            @php
                $customerRate = DB::table('customer_rates')->where('indent_id',$confirmedIndent->id)->first();
                $confirmedRate = DB::table('rates')->where('indent_id',$confirmedIndent->id)->where('is_confirmed_rate', 1)->first();
                $supplierName = DB::table('users')->where('id', $confirmedRate->user_id)->first();
            @endphp
            <tr>
                <td> 
                    @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2 || auth()->user()->role_id == 3)
                        <a href="{{ route('createDriver', ['id' => $confirmedIndent->id]) }}" class="text-primary me-2">{{ $confirmedIndent->getUniqueENQNumber() }}</a>
                    @else
                        {{ $confirmedIndent->getUniqueENQNumber() }}
                    @endif
                    </td>
                @if(auth()->user()->role_id != 4)
                    <td>{{ $confirmedIndent->customer_name }}</td>
                    <td>{{ $confirmedIndent->company_name }}</td>
                    <td>{{ $confirmedIndent->number_1 }}</td>
                    @endif
                <td>{{ $confirmedIndent->pickup_location_id }}</td>
                <td>{{ $confirmedIndent->drop_location_id }}</td>
                <td>{{ ($confirmedIndent->materialType != null) ? $confirmedIndent->materialType->name : 'N/A' }}</td>
                <td>{{ $confirmedIndent->truckType->name }}</td>
                <td>{{ $confirmedIndent->body_type }}</td>
                <td>{{ $confirmedIndent->weight }} {{ $confirmedIndent->weight_unit }}</td>
                <td>@if($confirmedIndent->indentRate->isNotEmpty())
                    {{ $confirmedIndent->indentRate->where('is_confirmed_rate', 1)->first()->rate }}
                    @else
                    N/A
                    @endif
                </td>
                @if(auth()->user()->role_id != 4)
                    <td>
                       {{ ($customerRate != null) ? $customerRate->rate : 'N/A' }} 
                    </td>
                @endif
                <td>
                   {{ ($confirmedIndent->user) ? $confirmedIndent->user->name : 'N/A' }}
                </td>
                <td>
                   {{ ($supplierName) ? $supplierName->name : 'N/A' }}
                </td>
                <td>
                   {{ $confirmedIndent->created_at->format('Y-m-d') }}
                </td>
                <td>{{ $confirmedIndent->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $confirmedTrips->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
    
</div>
@endsection


<style>
    p {
        text-align: left;
    }

    .label-width {
        width: 130px;
        /* Adjust the width according to your preference */
        display: inline-block;
    }

    span {
        display: inline-block;
        text-align: left;
        margin-left: 30px;
        /* Adjust the margin to add space between label and value */
    }
</style>