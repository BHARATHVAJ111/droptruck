@extends('layouts.sidebar')
@section('content')
<div class="d-flex justify-content-end gap-2">
    <div>
        <form class="mt-3" method="GET" action="{{ url('/search/vehicle') }}">
            <input class="form-control" name="query" type="search" placeholder="search...">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
    <div>
        <button type="button" class="btn dash1 mt-3">
            <a href="{{ route('suppliers.create') }}" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#customerModal"> Add Vechicles</a>
        </button>
        @include('vehicles.create')
    </div>
</div>
<div class="mb-4 mt-1">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>
                    <th>Body Type</th>
                    <th>Tonnage Passing</th>
                    <th>Driver Number</th>
                    <th>Remarks</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->vehicle_number }}</td>
                    <td>{{ $vehicle->vehicle_type }}</td>
                    <td>{{ $vehicle->tonnage_passing }}</td>
                    <td>{{ $vehicle->driver_number }}</td>
                    <td>{{ $vehicle->remarks}}</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <div>@include('vehicles.edit')</div>
                        <a href="{{ route('vehicles.show', $vehicle->id) }}">
                            <i class="fa fa-eye" style="font-size:17px"></i>
                        </a>
                        <div>@include('vehicles.delete')</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection