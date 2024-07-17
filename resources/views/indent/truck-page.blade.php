<!-- confirmation.blade.php -->

@extends('layouts.sidebar')

@section('content')
<div class="d-flex justify-content-between gap-2 mt-3">
    <div class="fw-bolder display-6 text-success text-uppercase">Ready For Trip</div>
    <div>
    <a class="btn dash1 float-end m-3" href="{{ route('fetch-last-two-details') }}">Quoted</a>
    </div>
</div>
<div id="quoted-content">
    <div class="horizontal-menu mt-3">
<ul>
            <li class="{{ request()->is('indents/index') ? 'active' : '' }}">
                <a href="#." class="dropdown-item">Waiting For Driver</a>
            </li>
            <li class="{{ request()->is('fetch-last-two-details') ? 'active' : '' }}">
                <a class="dropdown-item" href="{{ route('fetch-last-two-details') }}">Loading</a>
            </li>
            <li class="{{ request()->is('fetch-last-two-details') ? 'active' : '' }}">
                <a class="dropdown-item" href="{{ route('fetch-last-two-details') }}">POD</a>
            </li>
            <li class="{{ request()->is('fetch-last-two-details') ? 'active' : '' }}">
                <a class="dropdown-item" href="{{ route('fetch-last-two-details') }}">On The Road</a>
            </li>
            <li class="{{ request()->is('fetch-last-two-details') ? 'active' : '' }}">
                <a class="dropdown-item" href="{{ route('fetch-last-two-details') }}">Unloading</a>
            </li>
            <li class="{{ request()->is('fetch-last-two-details') ? 'active' : '' }}">
                <a class="dropdown-item" href="{{ route('fetch-last-two-details') }}">Confirm Trips</a>
            </li>
</ul>
    </div>

<div class="card shadow border" style="margin:5% 20% 0 20%">
    <h5 class="card-header text-center mb-4 bg-warning">{{ $indents->customer_name }}</h5>
    <div class="card-body text-center">
        @if(auth()->user()->type == 'superadmin' || auth()->user()->type == 'admin' || auth()->user()->type == 'sales')
        <p class="card-text"><strong class="label-width">Pickup Location:</strong> <span> {{ $indents->pickup_locations }}</span></p>
        <p class="card-text"><strong class="label-width">Drop Location:</strong><span> {{ $indents->drop_locations }}</span></p>
        <p class="card-text"><strong class="label-width">Truck Type:</strong><span>{{ $indents->truck_type }}</span></p>
        <p class="card-text"><strong class="label-width">Body Type:</strong><span>{{ $indents->body_type }}</span></p>
        <p class="card-text"><strong class="label-width">Weight:</strong><span>{{ $indents->weight }}</span></p>
        <p class="card-text"><strong class="label-width">Material Type:</strong><span>{{ $indents->material_type }}</span></p>
        <p class="card-text"><strong class="label-width">Hard Copy:</strong><span>{{ $indents->pod_soft_hard_copy }}</span></p>
            <a href="{{ route('cancel-trips', $indents->id) }}" class="btn btn-success mt-3">Cancel The Trips</a>
        @endif
    </div>
</div>
</div>

@endsection


<style>
    p {
        text-align: left;
    }
    .label-width {
    width: 130px; /* Adjust the width according to your preference */
    display: inline-block;
}

span {
    display: inline-block;
    text-align: left;
    margin-left: 30px; /* Adjust the margin to add space between label and value */
}


</style>