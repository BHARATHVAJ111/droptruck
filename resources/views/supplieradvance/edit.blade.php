@extends('layouts.sidebar')

@section('content')
<div class="card mx-auto" style="width: 500px; margin-top:150px;">
<div class="card-header dash1">
        Edit Supplier Advance
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('supplier_advances.update', ['supplierAdvance' => $supplierAdvance->id]) }}">
            @csrf
            @method('PUT')
            <div class="form-group" style="display:none;">
                <label for="edit_indent_id">Indent ID</label>
                <input type="text" class="form-control" id="edit_indent_id" name="indent_id" value="{{ $supplierAdvance->indent_id }}" required>
            </div>
            <div class="form-group">
                <label for="edit_advance_amount">Advance Amount</label>
                <input type="text" class="form-control" id="edit_advance_amount" name="advance_amount" value="{{ $supplierAdvance->advance_amount }}" required>
            </div>
            <!-- Add other form fields as needed -->
            <br>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <!-- <form action="{{ route('supplier_advances.destroy', ['supplierAdvance' => $supplierAdvance->id]) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form> -->
    </div>
</div>
@endsection
