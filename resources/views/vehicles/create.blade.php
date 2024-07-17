<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F98917;">
                <h5 class="modal-title" id="customerModalLabel">Add Vehicles</h5>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'vehicles.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                {{-- Vehicle Number --}}
                <div class="form-group mb-3">
                    {!! Form::label('vehicle_number', 'Vehicle Number') !!}
                    {!! Form::text('vehicle_number', null, ['class' => 'form-control', 'required']) !!}
                </div>

                {{-- Vehicle Type --}}
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
                    ], null, ['class' => 'form-control']) !!}
                </div>


                {{-- Body Type --}}
                <div class="form-group mb-3">
                    {!! Form::label('body_type', 'Body Type') !!}
                    {!! Form::select('body_type', [
                    'Open' => 'Open',
                    'Container' => 'Container',
                    ], null, ['class' => 'form-control']) !!}
                </div>


                {{-- Tonnage Passing --}}
                <div class="form-group mb-3">
                    {!! Form::label('tonnage_passing', 'Tonnage Passing') !!}
                    {!! Form::number('tonnage_passing', null, ['class' => 'form-control', 'required']) !!}
                </div>

                {{-- Driver Number --}}
                <div class="form-group mb-3">
                    {!! Form::label('driver_number', 'Driver Number') !!}
                    {!! Form::text('driver_number', null, ['class' => 'form-control', 'required']) !!}
                </div>

                {{-- Status --}}
                <div class="form-group mb-3">
                    {!! Form::label('status', 'Status') !!}
                    {!! Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], null, ['class' => 'form-control', 'required']) !!}
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('rc_book', 'RC Book') !!}
                    {!! Form::file('rc_book', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('driving_license', 'Driving License') !!}
                    {!! Form::file('driving_license', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('remarks', 'Remarks:') !!}
                    {!! Form::textarea('remarks', null, ['class' => 'form-control', 'id' => 'remarks', 'rows' => 3]) !!}
                </div>


                {{-- Submit Button --}}
                <div class="form-group d-grid gap-3">
                    {!! Form::submit('Create Vehicle', ['class' => 'btn dash1']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>