@extends('layouts.sidebar')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header dash1 text-white">
            <h2 class="card-title">Create POD</h2>
        </div>
        <div class="card-body">
            <form id="podForm" action="{{ route('pods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <input type="hidden" name="indent_id" value="{{ $indent->id }}">
                    <button class="btn btn-danger float-end mb-1">{{ $indent->getUniqueENQNumber() }}</button>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="togglePodForm">
                    <label class="form-check-label" for="togglePodForm">
                        Fill POD Form
                    </label>
                </div>

                <div id="podFormFields" style="display: none;">
                    <div class="form-group col-lg-3">
                        <label for="courier_receipt_no">Courier Receipt No:</label>
                        <input type="text" name="courier_receipt_no" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="pod_soft_copy">Pod Soft Copy:</label>
                        <input type="file" name="pod_soft_copy" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="pod_courier">Pod Courier:</label>
                        <input type="file" name="pod_courier" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="d-dlex mt-3">
                        <button type="submit" name="submit_with_data" value="true" class="btn btn-primary mt-3">Submit with Data</button>
                        <button type="submit" name="submit_without_data" value="true" class="btn btn-danger mt-3">Submit without Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePodForm').addEventListener('change', function() {
        var podFormFields = document.getElementById('podFormFields');
        podFormFields.style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection