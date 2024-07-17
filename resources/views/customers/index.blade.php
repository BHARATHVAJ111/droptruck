@extends('layouts.sidebar')
@section('content')
<div class="d-flex justify-content-end gap-2">
    <div>
        <form type="get" action="{{url('/search/customer')}}">
            <input class="form-control mt-3" name="query" type="search" placeholder="search...">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
    <div>
        <button type="button" class="btn dash1 mt-3">
            <a href="{{ route('customers.create') }}" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#customerModal"> Create Customer</a>
        </button>
        @include('customers.create')
    </div>
</div>



<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Contact Number</th>
                <th>Company Name</th>
                <th>Address</th>
                <th>GST Number</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ $customer->contact_number }}</td>
                <td>{{ $customer->company_name }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->gst_number }}</td>
                <td>{{$customer->remarks}}</td>
                <td>
                    <a href="{{ route('customers.show', $customer->id) }}">
                        <i class="fa fa-eye" style="font-size:17px"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $customers->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
</div>
@endsection