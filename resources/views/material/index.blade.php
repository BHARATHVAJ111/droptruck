@extends('layouts.sidebar')
@section('content')

<?php //echo 'sddsdsds'; exit; ?>
<div class="d-flex justify-content-end gap-2">
    <div>
        <form class="mt-3" method="GET" action="{{ url('/search/vehicle') }}">
            <input class="form-control" name="query" type="search" placeholder="search...">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
    <div>
        <button type="button" class="btn dash1 mt-3">
            <a href="{{ route('materials.create') }}" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#customerModal"> Add Material Type</a>
        </button>
        @include('material.create')
    </div>
</div>
<div class="mb-4 mt-1">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Martial Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($materialTypes as $materialType)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $materialType->name }}</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <a href="{{ route('vehicles.show', $materialType->id) }}">
                            <i class="fa fa-eye" style="font-size:17px"></i>
                        </a>
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection