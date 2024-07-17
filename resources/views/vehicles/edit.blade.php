<a href="{{ route('vehicles.edit', $vehicle->id) }}" data-bs-toggle="modal" data-bs-target="#updateEmployeeModal"><i class="fa fa-edit" style="font-size:17px;"></i></a>

<div class="modal fade" id="updateEmployeeModal" tabindex="-1" aria-labelledby="updateEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#F98917">
                <h5 class="modal-title text-white fw-bolder text-center" id="updateEmployeeModalLabel">Update Truck</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::model($vehicle, ['route' => ['vehicles.update', $vehicle->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                <div class="mb-3">
                    {!! Form::label('vehicle_number', 'Vehicle Number', ['class' => 'form-label']) !!}
                    {!! Form::text('vehicle_number', null, ['class' => 'form-control', 'id' => 'vehicle_number']) !!}
                </div>

                <!-- Additional fields -->
                <div class="form-group mb-3">
                    {!! Form::label('vehicle_type', 'Vehicle Type') !!}
                    {!! Form::select('vehicle_type', [
                    'TATA ACE' => 'TATA ACE',
                    'ASHOK LEYLAND DOST' => 'ASHOK LEYLAND DOST',
                    'MAHINDRA BOLERO PICK UP' => 'MAHINDRA BOLERO PICK UP',
                    'ASHOK LEYLAND BADA DOST' => 'ASHOK LEYLAND BADA DOST',
                    'TATA 407' => 'TATA 407',
                    'EICHER 14 FEET' => 'EICHER 14 FEET',
                    'EICHER 17 FEET' => 'EICHER 17 FEET',
                    'EICHER 19 FEET' => 'EICHER 19 FEET',
                    'TATA 22 FEET' => 'TATA 22 FEET',
                    'TATA TRUCK (6 TYRE)' => 'TATA TRUCK (6 TYRE)',
                    'TAURUS 16 T (10 TYRE)' => 'TAURUS 16 T (10 TYRE)',
                    'TAURUS 21 T (12 TYRE)' => 'TAURUS 21 T (12 TYRE)',
                    'TAURUS 25 T (14 TYRE)' => 'TAURUS 25 T (14 TYRE)',
                    'CONTAINER 20 FT' => 'CONTAINER 20 FT',
                    'CONTAINER 32 FT SXL' => 'CONTAINER 32 FT SXL',
                    'CONTAINER 32 FT MXL' => 'CONTAINER 32 FT MXL',
                    'CONTAINER 32 FT SXL / MXL HQ' => 'CONTAINER 32 FT SXL / MXL HQ',
                    '20 FEET OPEN ALL SIDE (ODC)' => '20 FEET OPEN ALL SIDE (ODC)',
                    '28-32 FEET OPEN-TRAILOR JCB ODC' => '28-32 FEET OPEN-TRAILOR JCB ODC',
                    '32 FEET OPEN-TRAILOR ODC' => '32 FEET OPEN-TRAILOR ODC',
                    '40 FEET OPEN-TRAILOR ODC' => '40 FEET OPEN-TRAILOR ODC',
                    ], $vehicle->vehicle_type, ['class' => 'form-control']) !!}
                </div>


                <div class="mb-3">
                    {!! Form::label('body_type', 'Body Type', ['class' => 'form-label']) !!}
                    {!! Form::select('body_type', [
                    'Open' => 'Open',
                    'Container' => 'Container',
                    ], $vehicle->body_type, ['class' => 'form-control']) !!}
                </div>


                <div class="mb-3">
                    {!! Form::label('tonnage_passing', 'Tonnage Passing', ['class' => 'form-label']) !!}
                    {!! Form::text('tonnage_passing', null, ['class' => 'form-control', 'id' => 'tonnage_passing']) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('driver_number', 'Driver Number', ['class' => 'form-label']) !!}
                    {!! Form::text('driver_number', null, ['class' => 'form-control', 'id' => 'driver_number']) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
                    {!! Form::text('status', null, ['class' => 'form-control', 'id' => 'status']) !!}
                </div>

                <div class="mb-3">
                    {!! Form::label('rc_book', 'RC Book') !!}
                    {!! Form::file('rc_book', ['class' => 'form-control', 'id' => 'rc_book']) !!}
                </div>
                @if($vehicle->rc_book)
                    <p >
                        <img id="rcBookPreview" src="{{ asset($vehicle->rc_book) }}" alt="RC Book Preview" style="height:100px; width:100px;">
                    </p>
                @endif

                <div class="mb-3">
                    {!! Form::label('driving_license', 'Driving License') !!}
                    {!! Form::file('driving_license', ['class' => 'form-control', 'id' => 'driving_license']) !!}
                </div>
                @if($vehicle->driving_license)
                    <p>
                        <img id="drivingLicensePreview" src="{{ asset($vehicle->driving_license) }}" alt="Driving License Preview" style="height:100px; width:100px;">
                    </p>
                @endif

                <div class="form-group mb-3">
                            <label for="remarks">Remarks:</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="3">{{  $vehicle->remarks }}</textarea>
                        </div>


                <div class="form-group d-grid gap-3">
                    {!! Form::submit('Update', ['class' => 'btn dash1']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>