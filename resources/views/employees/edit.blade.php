<div class="modal fade" id="updateEmployeeModal" tabindex="-1" aria-labelledby="updateEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#F98917">
                <h5 class="modal-title text-white fw-bolder text-center" id="updateEmployeeModalLabel">Update Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('employees.update', $users->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ $users->name }}" class="form-control mt-3">

                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ $users->email }}" class="form-control mt-3">

                    <label for="contact">Contact</label>
                    <input type="text" name="contact" value="{{ $users->contact }}" class="form-control mt-3">

                    <label for="designation">Designation</label>
                    <input type="text" name="designation" value="{{ $users->designation }}" class="form-control mt-3">

                    <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-select">
    <option value="1" {{ $users->status === '1' ? 'selected' : '' }}>Active</option>
    <option value="0" {{ $users->status === '0' ? 'selected' : '' }}>Inactive</option>
</select>

            @if ($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
            @endif
        </div>
                    <label for="remarks">Remarks:</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="3">{{ $users->remarks }}</textarea>


                    <div class="d-grid gap-3 mt-3">
                        <button type="submit" class="btn dash1">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>