@extends('layouts.sidebar')

@section('content')
@if(Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger">
    {{ Session::get('error') }}
</div>
@endif
<?php //echo 'sdsds<pre>'; print_r(); exit; ?>
<div class="container mt-3">
    <div class="card">
        <h1 class="btn dash1 text-white fw-bolder">Vehicle Details</h1>
        <div class="ms-2">
            <button type="button" class="btn btn-danger mt-1" style="font-size: 8px; padding: 5px 10px;" data-toggle="modal" data-target="#cancelModal">
                Cancel
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('cancel-indents-by-locations') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pickup_location_id" value="{{ $pickupLocationId }}">
                        <input type="hidden" name="drop_location_id" value="{{ $dropLocationId }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel">Select Reason for Cancellation:</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="reason">Select Reason for Cancellation:</label>
                                <select class="form-control" id="reason" name="reason">
                                    <option value="Not Responding">Not Responding</option>
                                    <option value="Material not ready">Material not ready</option>
                                    <option value="Duplicate Enquiry">Duplicate Enquiry</option>
                                    <option value="Unavailability of vehicle">Unavailability of vehicle</option>
                                    <option value="Trip Postponed">Trip Postponed</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form action="{{ route('storeDriverDetails') }}" method="post" class=" d-flex justify-content-center mt-3" enctype="multipart/form-data">
            @csrf
            <div class="row d-flex justify-content-end me-2">
                <div class="col-lg-2 m-2">
                    <input type="hidden" id="indent_id" name="indent_id" value="{{ $indent->id }}">
                    <input type="text" class="form-control btn btn-danger" id="unique_enq_number" name="unique_enq_number" value="{{ $uniqueENQNumber }}" readonly>
                </div>
                @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    <div class="row d-flex justify-content-center">
                        <div class="mb-3 col-lg-5">
                            <label for="driver_name" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="">
                            <input type="hidden" class="form-control" id="supplier_id" name="supplier_id" value="">
                        </div>
                    </div>
                @endif
                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-5">
                        <label for="driver_name" class="form-label">Driver Name</label>
                        <input type="text" class="form-control" id="driver_name" name="driver_name">
                    </div>

                    <div class="mb-3 col-lg-5">
                        <label for="driver_number" class="form-label">Driver Number</label>
                        <input type="text" class="form-control" id="driver_number" name="driver_number">
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-5">
                        <label for="vehicle_number" class="form-label">Vehicle Number</label>
                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number">
                    </div>

                    <div class="mb-3 col-lg-5">
                        <label for="vehicle_number" class="form-label">Body Type</label>
                        <select class="form-select form-select-sm" id="vehicle_type" name="vehicle_type">
                            <option value="select">select</option>
                            <option value="Open">Open</option>
                            <option value="Container">Container</option>
                        </select>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-5" id="truck_type_option">
                    <label for="truck_type_id">Truck Type </label>
                    <div class="input-group">
                        <select name="truck_type" id="truck_type" class="form-select form-select-sm">
                            <option value="">Select</option>
                            @foreach ($truckTypes as $truckType)
                            <option value="{{ $truckType->id }}">{{ $truckType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mt-1" id="new_truck_type_text" style="display:none;">
                    <label for="new_material_type">Truck Type</label>
                    <input type="text" class="form-control form-control-sm" id="new_truck_type" name="new_truck_type" placeholder="Pleae Enter Truck Type">
                </div>

                    <div class="mb-3 col-lg-5">
                        <label for="driver_base_location" class="form-label">Driver Base Location</label>
                        <input type="text" class="form-control" id="driver_base_location" name="driver_base_location">
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-5">
                        <label for="vehicle_photo" class="form-label">Vehicle Photo</label>
                        <input type="file" class="form-control" id="vehicle_photo" name="vehicle_photo" accept="image/*">
                    </div>
                    <div class="mb-3 col-lg-5">
                        <label for="driver_license" class="form-label">Driver License</label>
                        <input type="file" class="form-control" id="driver_license" name="driver_license" accept="image/*">
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="mb-3 col-lg-5">
                        <label for="rc_book" class="form-label">RC Book</label>
                        <input type="file" class="form-control" id="rc_book" name="rc_book" accept="image/*">
                    </div>

                    <div class="mb-3 col-lg-5">
                        <label for="insurance" class="form-label">Insurance</label>
                        <input type="file" class="form-control" id="insurance" name="insurance" accept="image/*">
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <div>
                        <button type="submit" class="btn btn-primary d-flex justify-content-center">Move to Loading</button>
                    </div>
                    <!-- <div>
                <button type="button" class="btn dash1 ms-5 justify-content-center">Move to Loading</button>
                </div> -->
                </div>
        </form>
    </div>
</div>
</div>
<!-- Add these links in the head section of your HTML file -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#indent_id').select2({
            allowClear: true,
        });
    });
</script>
@endsection