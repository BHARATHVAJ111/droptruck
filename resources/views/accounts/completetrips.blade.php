<!-- resources/views/indents/status6.blade.php -->

@extends('layouts.sidebar')

@section('content')
<style>
    th {
        color: blueviolet;
    }

    .btn-warning.custom-active {
        background: linear-gradient(135deg, #007bff, #8a2be2);
        color: #fff;
        border: #8a2be2;
    }

    .bg-gradient-info {
        background-image: radial-gradient(515px at 48.7% 52.8%, rgb(239, 110, 110) 0%, rgb(230, 25, 25) 46.5%, rgb(154, 11, 11) 100.2%);
    }
</style>
<div class="m-3">
        <a class="btn btn-warning" href="{{ route('accounts.ongoing') }}" style="font-size: 12px; padding: 5px 10px;">Ongoing</a>
        <a class="btn btn-warning" href="{{route('pendingtrips')}}" style="font-size: 12px; padding: 5px 10px;">Complete trips with pending</a>
        <a class="btn btn-warning custom-active" href="{{route('accounts.completetrips')}}" style="font-size: 12px; padding: 5px 10px;">Complete Trips</a>
        <a href="{{ route('export-to-excel') }}" class="btn btn-sm float-end btn-success">Export to Excel</a>
    </div>
<div class="container mt-3">

    <table class="table table-bordered table-striped table-hover" style="font-size:8px;">
        <thead>
            <tr>
                <th class="bg-gradient-info text-light">ID</th>
                <th class="bg-gradient-info text-light">Pickup Location</th>
                <th class="bg-gradient-info text-light">Drop Location</th>
                <th class="bg-gradient-info text-light">Driver Name</th>
                <th class="bg-gradient-info text-light">Driver Number</th>
                <th class="bg-gradient-info text-light">Vehicle Number</th>
                <th class="bg-gradient-info text-light">Customer Advances</th>
                <th class="bg-gradient-info text-light">Customer Balance Amount</th> <!-- New column for Customer Balance Amount -->
                <th class="bg-gradient-info text-light">Supplier Advances</th>
                <th class="bg-gradient-info text-light">Supplier Balance Amount</th> <!-- New column for Supplier Balance Amount -->
                <th class="bg-gradient-info text-light">Extra Costs</th>
                <th class="bg-gradient-info text-light">Supplier Details</th>
                <th class="bg-gradient-info text-light">Supplier Type</th>
                <th class="bg-gradient-info text-light">Supplier Company</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indents as $indent)
                @foreach ($indent->driverDetails as $driverDetail)
                    @php 
                        $supplierDetails = $indent->suppliers->first();
                    @endphp
                    <tr>
                        <td>{{ $indent->getUniqueENQNumber() }}</td>
                        <td>{{ $indent->pickup_location_id }}</td>
                        <td>{{ $indent->drop_location_id }}</td>
                        <td>{{ $driverDetail->driver_name }}</td>
                        <td>{{ $driverDetail->driver_number }}</td>
                        <td>{{ $driverDetail->vehicle_number }}</td>
                        <td>{{ $indent->customerAdvances->sum('advance_amount') }}</td>
                        <td>{{ optional($indent->customerAdvances->last())->balance_amount }}</td>
                        <td>{{ $indent->supplierAdvances->sum('advance_amount') }}</td>
                        <td>{{ optional($indent->supplierAdvances->last())->balance_amount }}</td>
                        <td>
                            @foreach ($indent->extraCosts as $extraCost)
                                 {{ $extraCost->amount }}<br>
                            @endforeach
                        </td>
                        <td>
                            {{ ($supplierDetails) ? $supplierDetails->supplier_name : '' }}
                        </td>
                        <td>{{ ($supplierDetails) ? $supplierDetails->supplier_type : '' }}</td>
                        <td>{{ ($supplierDetails) ? $supplierDetails->company_name : '' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
