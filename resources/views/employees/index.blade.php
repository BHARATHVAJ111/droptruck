@extends('layouts.sidebar')
@section('content')
<div class="d-flex justify-content-end gap-2">
    <div>
        <form class="form-inline mt-3" type="get" action="{{url('/search/employee')}}">
            <input class="form-control" name="query" type="search" placeholder="search...">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
    <div>
        <button type="button" class="btn dash1 mt-3">
            <a href="{{ route('employees.create') }}" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#exampleModal"> Add Employee</a>
        </button>
        @include('employees.create')
    </div>
</div>
<table class="table table-bordered text-start">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Designation</th>
            <th>Role</th>
            <th>Status</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody style="background-color:#D9D9D9;">
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->contact }}</td>
            <td>{{ $user->designation }}</td>
            <td>{{ $user->role->type }}</td>
            <td>
                <button class="btn {{ $user->status ? 'btn-primary' : 'btn-danger' }}">
                    {{ $user->status ? 'Active' : 'Inactive' }}
                </button>
            </td>

            <!-- Display status -->
            <td>{{ $user->remarks }}</td>
            <td>
                <a href="{{ route('employees.view', ['id' => $user->id]) }}">
                    <i class="fa fa-eye" style="font-size:17px"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection