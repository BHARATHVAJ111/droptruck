@extends('layouts.sidebar')

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

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
    <div class="m-3">
        <a class="btn btn-warning" href="{{route('confirmed-trips')}}" style="font-size: 12px; padding: 5px 10px;">Waiting for driver</a>
        <a class="btn btn-warning" href="{{route('trips.index')}}" style="font-size: 12px; padding: 5px 10px;">Loading</a>
        <a class="btn btn-warning" href="{{route('loading')}}" style="font-size: 12px; padding: 5px 10px;">On The Road</a>
        <a class="btn btn-warning" href="{{route('unloading')}}" style="font-size: 12px; padding: 5px 10px;">Unloading</a>
        <a class="btn btn-warning custom-active" href="{{route('extra_costs.index')}}" style="font-size: 12px; padding: 5px 10px;position:relative;">Pod
        <span class="badge badge-primary circle-badge text-light" id="canceledIndentsCount" style="position: absolute; top: -10px; right: -10px; background: linear-gradient(45deg, #F31559, #F6635C);">
        {{ $extraCosts->count() }}
    </span>
    </a>
        <a class="btn btn-warning" href="{{route('pods.index')}}" style="font-size: 12px; padding: 5px 10px;">Complete Trips</a>
    </div>
</div>
<div class="container">


    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <table class="table table-bordered table-striped table-hover" style="font-size:8px;">
        <thead>
            <tr>
                <th class="bg-gradient-info text-light">Enq NO</th>
                <th class="bg-gradient-info text-light">Sales Person</th>
                <th class="bg-gradient-info text-light">Supplier Name</th>
                <th class="bg-gradient-info text-light">Extra Cost Type</th>
                <th class="bg-gradient-info text-light">Amount</th>
                <th class="bg-gradient-info text-light">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($extraCosts as $extraCost)
                @php
                    $confirmedRate = DB::table('rates')->where('indent_id',$extraCost->indent_id)->where('is_confirmed_rate', 1)->first();
                    if($confirmedRate) {
                        $supplierName = DB::table('users')->where('id', $confirmedRate->user_id)->first();
                    }
                    else{
                        $supplierName = '';
                    }
                    $salesPerson = DB::table('users')->where('id', $extraCost->indent->user_id)->first();
                @endphp

                
            <tr>
                <td>
                    <a href="{{ route('pods.create', ['id' => $extraCost->indent->id]) }}" class="text-primary">{{ $extraCost->indent->getUniqueENQNumber() }}</a>
                </td>
                <td>{{ ($salesPerson) ? $salesPerson->name : 'N/A' }}</td>
                <td>{{ ($supplierName) ? $supplierName->name : 'N/A' }}</td>
                <td>{{ $extraCost->extra_cost_type }}</td>
                <td>{{ $extraCost->amount }}</td>
                <td>
                    <a href="{{ route('extra_costs.edit', $extraCost->id) }}" class="text-info"> <i class="fas fa-edit" style="font-size:8px;color:#007bff;"></i></a>
                    <form action="{{ route('extra_costs.destroy', $extraCost->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"  style="font-size:8px;color:red;"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $extraCosts->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
</div>
@endsection