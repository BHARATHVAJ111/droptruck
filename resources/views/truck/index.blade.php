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
        <a class="btn btn-warning" href="{{route('confirmed-trips')}}" style="font-size: 12px; padding: 5px 10px;">Waiting for driver</a>
        <a class="btn btn-warning  custom-active" href="{{route('trips.index')}}" style="font-size: 12px; padding: 5px 10px;position:relative;">Loading
        <span class="badge badge-primary circle-badge text-light" id="canceledIndentsCount" style="position: absolute; top: -10px; right: -10px; background: linear-gradient(45deg, #F31559, #F6635C);">
        {{ $trips->count() }}
    </span>
    </a>
        <a class="btn btn-warning" href="{{route('loading')}}" style="font-size: 12px; padding: 5px 10px;">On The Road</a>
        <a class="btn btn-warning" href="{{route('unloading')}}" style="font-size: 12px; padding: 5px 10px;">Unloading</a>
        <a class="btn btn-warning" href="{{route('extra_costs.index')}}" style="font-size: 12px; padding: 5px 10px;">Pod</a>
        <a class="btn btn-warning" href="{{route('pods.index')}}" style="font-size: 12px; padding: 5px 10px;">Complete Trips</a>
    </div>
</div>
<div class="container">

    <table class="table table-bordered table-striped table-hover" style="font-size:8px">
        <thead>
            <tr>
                <th class="bg-gradient-info text-light">Enq No</th>
                @if(auth()->user()->role_id != 4)
                    <th class="bg-gradient-info text-light">Customer Name</th>
                    <th class="bg-gradient-info text-light">Company Name</th>
                    <th class="bg-gradient-info text-light">Number 1</th>
                @endif
                <th class="bg-gradient-info text-light">Driver Name</th>
                <th class="bg-gradient-info text-light">Driver Number</th>
                <th class="bg-gradient-info text-light">Vehicle Number</th>
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
            @foreach ($trips as $trip)
            @php
                $confirmedRate = DB::table('rates')->where('indent_id',$trip->id)->where('is_confirmed_rate', 1)->first();
                $supplierName = DB::table('users')->where('id', $confirmedRate->user_id)->first();
                $salesPerson = DB::table('users')->where('id', $trip->user_id)->first();
            @endphp
            @foreach ($trip->driverDetails as $driverDetail)
            <tr>
            <td>
                @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    <a href="{{ route('suppliers.create', ['indentId' => $trip->id]) }}" class="text-primary">{{ $trip->getUniqueENQNumber() }} </a>
                @else
                    <a href="{{ route('driver-details', ['id' => $driverDetail->indent_id]) }}" class="text-primary me-2">
                        {{ $trip->getUniqueENQNumber() }}
                    </a>
                @endif
                </td>
                @if(auth()->user()->role_id != 4)
                    <td>{{ $driverDetail->indent->customer_name }}</td>
                    <td>{{ $driverDetail->indent->company_name }}</td>
                    <td>{{ $driverDetail->indent->number_1 }}</td>
                @endif
                <td>{{ $driverDetail->driver_name }}</td>
                <td>{{ $driverDetail->driver_number }}</td>
                <td>{{ $driverDetail->vehicle_number }}</td>
                <td>{{ $driverDetail->indent->pickup_location_id ? $driverDetail->indent->pickup_location_id : 'N/A' }}</td>
                <td>{{ $driverDetail->indent->drop_location_id ? $driverDetail->indent->drop_location_id : 'N/A' }}</td>
                <td>{{ ($driverDetail->indent->materialType != null) ? $driverDetail->indent->materialType->name : 'N/A' }}</td>
                <td>{{ $driverDetail->indent->truckType->name }}</td>
                <td>{{ $driverDetail->indent->body_type }}</td>
                <td>{{ $driverDetail->indent->weight }} {{ $driverDetail->indent->weight_unit }}</td>
                <td>@if($driverDetail->indentRate)
                    {{ $driverDetail->indentRate->where('is_confirmed_rate', 1)->first()->rate }}
                    @else
                    N/A
                    @endif
                </td>
                @if(auth()->user()->role_id != 4)
                    <td>
                       {{ ($driverDetail->indent != null) ? $driverDetail->indent->customer_rate : 'N/A' }} 
                    </td>
                @endif
                <td>{{ ($salesPerson) ? $salesPerson->name : 'N/A' }}</td>
                <td>{{ ($supplierName) ? $supplierName->name : 'N/A' }}</td>
                <td>{{ $driverDetail->indent->created_at }}</td>
                <td>{{ $driverDetail->indent->remarks }}</td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $trips->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
</div>
@endsection