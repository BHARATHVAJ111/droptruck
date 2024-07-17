<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }
        .card-body {
            padding: 10px;
        }
        .label-width {
            width: 150px;
            display: inline-block;
        }
        .detail-row {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="header">
            <h2>Trip Details</h2>
            <div class="text-center">
        <a href="{{ route('generate-invoice', ['id' => $indent->id]) }}" class="btn btn-primary" target="_blank">Download PDF</a>
    </div>
        </div>
        <div class="card">
            <div class="card-header">
                Full Trip Details
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <strong class="label-width">Pickup Location:</strong>
                    <span>{{ $indent->pickupLocation->district }}</span>
                </div>
                <div class="detail-row">
                    <strong class="label-width">Drop Location:</strong>
                    <span>{{ $indent->dropLocation->district }}</span>
                </div>
                <div class="detail-row">
                    <strong class="label-width">Truck Type:</strong>
                    <span>{{ $indent->truckType ? $indent->truckType->name : 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <strong class="label-width">Body Type:</strong>
                    <span>{{ $indent->body_type }}</span>
                </div>
                <div class="detail-row">
                    <strong class="label-width">Weight:</strong>
                    <span>{{ $indent->weight }}</span>
                </div>
                <div class="detail-row">
                    <strong class="label-width">Material Type:</strong>
                    <span>{{ $indent->materialType ? $indent->materialType->name : 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <strong class="label-width">Salesperson:</strong>
                    <span>{{ $indent->user->name }}</span>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                Driver Details
            </div>
            <div class="card-body">
                @foreach ($indent->driverDetails as $driverDetail)
                <div class="detail-row">
                    <strong>Driver Name:</strong>
                    <span>{{ $driverDetail->driver_name }}</span>
                </div>
                <div class="detail-row">
                    <strong>Driver Number:</strong>
                    <span>{{ $driverDetail->driver_number }}</span>
                </div>
                <div class="detail-row">
                    <strong>Vehicle Number:</strong>
                    <span>{{ $driverDetail->vehicle_number }}</span>
                </div>
                <div class="detail-row">
                    <strong>Driver Base Location:</strong>
                    <span>{{ $driverDetail->driver_base_location }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Customer & Supplier Advance Pending Status
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <strong>Customer Advances:</strong>
                    <span>{{ $indent->customerAdvances->sum('advance_amount') }}</span>
                </div>
                <div class="detail-row">
                    <strong>Customer Balance Amount:</strong>
                    <span>
                        @php
                            $totalAmount = optional($indent->customerRate)->rate;
                            $advanceSum = $indent->customerAdvances->sum('advance_amount');
                            $balanceAmount = $totalAmount - $advanceSum;
                            echo $balanceAmount;
                        @endphp
                    </span>
                </div>
                <div class="detail-row">
                    <strong>Supplier Advances:</strong>
                    <span>{{ $indent->supplierAdvances->sum('advance_amount') }}</span>
                </div>
                <div class="detail-row">
                    <strong>Supplier Balance Amount:</strong>
                    <span>{{ optional($indent->indentRate->last())->rate - $indent->supplierAdvances->sum('advance_amount') }}</span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
