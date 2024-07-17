@extends('layouts.sidebar')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-end gap-2">
        <div>
            <form type="get" action="{{url('/search/supplier')}}">
                <input class="form-control mt-3" name="query" type="search" placeholder="search...">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
        <div>
            <button type="button" class="btn dash1 mt-3" fdprocessedid="ucoki">
                <a href="/suppliers/create" class="text-decoration-none text-dark"> Add Supplier</a>
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Vendor Name</th>
                    <th>Vendor Type</th>
                    <th>Company Name</th>
                    <th>Contact Number</th>
                    <th>Pan Card</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->supplier_name }}</td>
                    <td>{{ $supplier->supplier_type }}</td>
                    <td>{{ $supplier->company_name }}</td>
                    <td>{{ $supplier->contact_number }}</td>
                    <td>{{ $supplier->pan_card_number }}</td>
                    <td>{{ $supplier->remarks }}</td>
                    <td>
                        <div>@include('suppliers.edit')</div>
                        <a href="{{ route('suppliers.show', $supplier->id) }}">
                            <i class="fa fa-eye" style="font-size:17px"></i>
                        </a>
                        <div>@include('suppliers.delete')</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center p-0 pagination-sm">
    {{ $suppliers->links('pagination::bootstrap-5', ['class' => 'pagination-sm']) }}
</div>
    </div>
</div>
@endsection