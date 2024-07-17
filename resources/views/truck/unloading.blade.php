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
    <div class="m-3" style="font-size:9px;">
        <a class="btn btn-warning btn-xs" href="{{route('confirmed-trips')}}" style="font-size: 12px; padding: 5px 10px;">Waiting for driver</a>
        <a class="btn btn-warning btn-sm" href="{{route('trips.index')}}" style="font-size: 12px; padding: 5px 10px;">Loading</a>
        <a class="btn btn-warning btn-sm" href="{{route('loading')}}" style="font-size: 12px; padding: 5px 10px;">On The Road</a>
        <a class="btn btn-warning btn-sm custom-active" href="{{route('unloading')}}" style="font-size: 12px; padding: 5px 10px;position:relative;">Unloading
        <span class="badge badge-primary circle-badge text-light" id="canceledIndentsCount" style="position: absolute; top: -10px; right: -10px; background: linear-gradient(45deg, #F31559, #F6635C);">
        {{ $suppliers->count() }}
    </span>
    </a>
        <a class="btn btn-warning btn-sm" href="{{route('extra_costs.index')}}" style="font-size: 12px; padding: 5px 10px;">Pod</a>
        <a class="btn btn-warning btn-sm" href="{{route('pods.index')}}" style="font-size: 12px; padding: 5px 10px;">Complete Trips</a>
    </div>
</div>
<table class="table table-bordered table-striped table-hover" style="font-size:8px;">
    <thead>
        <tr>
            <th class="bg-gradient-info text-light">ID</th>
             <th class="bg-gradient-info text-light">Sales Person</th>
            <th class="bg-gradient-info text-light">Supplier Name</th>
            <th class="bg-gradient-info text-light">Supplier Type</th>
            <th class="bg-gradient-info text-light">Company Name</th>
            <th class="bg-gradient-info text-light">Customer Advances</th>
            <!-- <th class="bg-gradient-info text-light">Customer Balance</th> -->
            <th class="bg-gradient-info text-light">Supplier Advances</th>
            <!-- <th class="bg-gradient-info text-light">Supplier Balance</th> -->
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $supplier)
            @php
                
                $confirmedRate = DB::table('rates')->where('indent_id',$supplier->indent->id)->where('is_confirmed_rate', 1)->first();
                if($confirmedRate) {
                    $supplierName = DB::table('users')->where('id', $confirmedRate->user_id)->first();
                    $salesPerson = DB::table('users')->where('id', $supplier->indent->user_id)->first();
                } else {
                    $supplierName = '';
                    $salesPerson = '';
                }
            @endphp
        <tr>
            <td>
                <a href="{{ route('extracost.create', ['indent_id' => optional($supplier->indent)->id]) }}" class="text-primary">
                    {{ optional($supplier->indent)->getUniqueENQNumber() ?? '' }}
                </a>
            </td>
            <td>{{ ($salesPerson) ? $salesPerson->name : 'N/A' }}</td>
            <td>{{ ($supplierName) ? $supplierName->name : 'N/A' }}</td>
            <td>{{ $supplier->supplier_type }}</td>
            <td>{{ $supplier->company_name }}</td>
            <td>
                @if($supplier->indent && $supplier->indent->customerAdvances->isNotEmpty())
                {{ $supplier->indent->customerAdvances->sum('advance_amount') }}
                @else
                N/A
                @endif
            </td>   
            <!-- <td>
                @if($supplier->indent && $supplier->indent->customerAdvances->isNotEmpty())
                {{ optional($supplier->indent->customerAdvances->last())->balance_amount ?? 'N/A' }}
                @else
                N/A
                @endif
            </td> -->


            <td>
                @if($supplier->indent && $supplier->indent->supplierAdvances->isNotEmpty())
                {{ $supplier->indent->supplierAdvances->sum('advance_amount') }}
                @else
                N/A
                @endif
            </td>

            <!-- <td>
                @if($supplier->indent && $supplier->indent->supplierAdvances->isNotEmpty())
                {{ optional($supplier->indent->supplierAdvances->last())->balance_amount ?? 'N/A' }}
                @else
                N/A
                @endif
            </td> -->


        </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $suppliers->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
@endsection