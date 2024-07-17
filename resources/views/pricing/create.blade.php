<div class="modal fade" id="pricingModal" tabindex="-1" role="dialog" aria-labelledby="pricingModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F98917;">
                <h5 class="modal-title" id="pricingModalLabel">Add Pricing</h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h2>Add Pricing</h2>
                    {!! Form::open(['route' => 'pricings.store', 'method' => 'POST']) !!}

                    <div class="form-group mt-3">
                        {!! Form::label('pickup_city', 'Pickup City') !!}
                        {!! Form::select('pickup_city', array_combine($cities, $cities), null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group mt-3">
                        {!! Form::label('drop_city', 'Drop City') !!}
                        {!! Form::select('drop_city', array_combine($cities, $cities), null, ['class' => 'form-control']) !!}
                    </div>


                    <div class="form-group mt-3">
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
                    <div class="form-group mt-3">
                        {!! Form::label('body_type', 'Body Type') !!}
                        {!! Form::select('body_type', [
                        'Open' => 'Open',
                        'Container' => 'Container',
                        ], null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group mt-3">
                        {!! Form::label('rate_from', 'Rate From') !!}
                        {!! Form::text('rate_from', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                    </div>

                    <div class="form-group mt-3">
                        {!! Form::label('rate_to', 'Rate To') !!}
                        {!! Form::text('rate_to', null, ['class' => 'form-control', 'step' => '0.01']) !!}
                    </div>

                    <div class="form-group mt-3">
                        <label for="remarks">Remarks:</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                    </div>

                    <div class="form-group d-grid gap-3 mt-3">
                        {!! Form::submit('Add Pricing', ['class' => 'btn dash1']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>