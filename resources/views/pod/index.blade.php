<!-- resources/views/pod/index.blade.php -->

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
        <a class="btn btn-warning " href="{{route('trips.index')}}" style="font-size: 12px; padding: 5px 10px;">Loading</a>
        <a class="btn btn-warning" href="{{route('loading')}}" style="font-size: 12px; padding: 5px 10px;">On The Road</a>
        <a class="btn btn-warning" href="{{route('unloading')}}" style="font-size: 12px; padding: 5px 10px;">Unloading</a>
        <a class="btn btn-warning" href="{{route('extra_costs.index')}}" style="font-size: 12px; padding: 5px 10px;">Pod</a>
        <a class="btn btn-warning custom-active" href="{{route('pods.index')}}" style="font-size: 12px; padding: 5px 10px;position:relative;">Complete Trips
        <span class="badge badge-primary circle-badge text-light" id="canceledIndentsCount" style="position: absolute; top: -10px; right: -10px; background: linear-gradient(45deg, #F31559, #F6635C);">
        {{ $pods->count() }}
    </span></a>
    </div>
</div>
<div class="container">
<table class="table table-bordered table-striped table-hover" style="font-size:8px;">
        <thead>
            <tr>
                <th class="bg-gradient-info text-light">Indent ID</th>
                <th class="bg-gradient-info text-light">Courier Receipt No</th>
                <th class="bg-gradient-info text-light">Pickup Location</th>
                <th class="bg-gradient-info text-light">Drop Location</th>
                <th class="bg-gradient-info text-light">Material Type</th>
                <th class="bg-gradient-info text-light">Truck Type</th>
                <th class="bg-gradient-info text-light">Body type</th>
                <th class="bg-gradient-info text-light">Weight</th>
                <th class="bg-gradient-info text-light">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pods as $pod)
            <tr>
                <td>
            <a href="{{ route('completed-trips.details', ['id' => $pod->indent->id]) }}" class="text-primary">
            {{ $pod->indent->getUniqueENQNumber() }}
        </a>
                </td>
                <td>{{ $pod->courier_receipt_no ? $pod->courier_receipt_no : 'N/A' }}</td>
                <td>{{ $pod->indent->pickup_location_id ? $pod->indent->pickup_location_id : 'N/A' }}</td>
                <td>{{ $pod->indent->drop_location_id ? $pod->indent->drop_location_id : 'N/A' }}</td>
                <td>{{ $pod->indent->materialType->name }}</td>
                <td>{{ $pod->indent->truckType->name }}</td>
                <td>{{ $pod->indent->body_type }}</td>
                <td>{{ $pod->indent->weight }} {{ $pod->indent->weight_unit }}</td>
                <td>
                    <a href="{{ route('pods.edit', $pod->id) }}" class="btn"> <i class="fas fa-edit" style="font-size:8px;color:#007bff;"></i></a>
                    <form action="{{ route('pods.destroy', $pod->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"  style="font-size:8px;color:red;"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 3||auth()->user()->role_id == 2) 
    <div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $pods->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
    @endif
</div>
</div>
@endsection