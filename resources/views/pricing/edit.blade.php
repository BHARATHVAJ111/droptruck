<a href="{{ route('pricings.edit', $pricing->id) }}" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#updatePricingModal">
    Update
</a>


<!-- Modal -->
<div class="modal fade" id="updatePricingModal" tabindex="-1" aria-labelledby="updatePricingModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable"  role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#F98917;color:white">
                <h5 class="modal-title" id="updatePricingModalLabel">Update Pricing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h2>Edit Pricing</h2>

                    {!! Form::model($pricing, ['route' => ['pricings.update', $pricing->id], 'method' => 'POST']) !!}
                    @method('PUT')

                    <div class="form-group mb-3">
                        {!! Form::label('pickup_city', 'Pickup City') !!}
                        <select name="pickup_city" class="form-control">
                            @foreach($cities as $city)
                            <option value="{{ $city }}" @if($pricing->pickup_city === $city) selected @endif>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        {!! Form::label('drop_city', 'Drop City') !!}
                        <select name="drop_city" class="form-control">
                            @foreach($cities as $city)
                            <option value="{{ $city }}" @if($pricing->drop_city === $city) selected @endif>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>


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
                        ], $pricing->vehicle_type, ['class' => 'form-control']) !!}
                    </div>


                    <div class="mb-3">
                        {!! Form::label('body_type', 'Body Type', ['class' => 'form-label']) !!}
                        {!! Form::select('body_type', [
                        'Open' => 'Open',
                        'Container' => 'Container',
                        ], $pricing->body_type, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group mb-3">
                        {!! Form::label('rate_from', 'Rate From') !!}
                        {!! Form::text('rate_from', $pricing->rate_from, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group mb-3">
                        {!! Form::label('rate_to', 'Rate To') !!}
                        {!! Form::text('rate_to', $pricing->rate_to, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('remarks', 'Remarks:') !!}
                        {!! Form::textarea('remarks', $pricing->remarks, ['class' => 'form-control', 'id' => 'remarks', 'rows' => 3]) !!}
                    </div>


                    <div class="form-group d-grid gap-3 mt-3">
                        {!! Form::submit('Update Pricing', ['class' => 'btn dash1']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>