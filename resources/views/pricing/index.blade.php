@extends('layouts.sidebar')

@section('content')
<div class="d-flex justify-content-end gap-2">
    <div>
        <form class="form-inline mt-3" type="get" action="{{ url('/search/pricing') }}">
            <input class="form-control" name="query" type="search" placeholder="search...">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
    <div>
        <button type="button" class="btn dash1 mt-3">
            <a href="{{ route('pricings.create') }}" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#pricingModal">Create Pricing</a>
        </button>
        @include('pricing.create')
    </div>
</div>

<table class="table  table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pickup City</th>
            <th>Drop City</th>
            <th>Vehicle Type</th>
            <th>Body Type</th>
            <th>Remarks</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pricings as $pricing)
        <tr>
            <td>{{ $pricing->id }}</td>
            <td>{{ $pricing->pickup_city }}</td>
            <td>{{ $pricing->drop_city }}</td>
            <td>{{ $pricing->vehicle_type }}</td>
            <td>{{ $pricing->body_type }}</td>
            <td>{{$pricing->remarks}}</td>
            <td>
                <a href="{{ route('pricings.show', ['pricing' => $pricing]) }}">
                    <i class="fa fa-eye" style="font-size:17px"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
   
<div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $pricings->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
@endsection
