@extends('layouts.dashboard')
@section('title')
    {{ translate('read_barcode') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('read_barcode') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('read_barcode') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">{{ translate('scan_barcode') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="barcodeInput">{{ translate('scan_barcode_for_receipt') }}</label>
                                    <input type="text" id="barcodeInput" class="form-control form-control-lg" 
                                           autofocus placeholder="{{ translate('Scan_the_barcode_here') }}" 
                                           style="font-size: 18px;">
                                    <small class="form-text text-muted">{{ translate('scan_barcode_to_receive_sample') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="barcodeInputStartWork">{{ translate('scan_barcode_to_start_work') }}</label>
                                    <input type="text" id="barcodeInputStartWork" class="form-control form-control-lg" 
                                           placeholder="{{ translate('Scan_the_barcode_here') }}" 
                                           style="font-size: 18px;">
                                    <small class="form-text text-muted">{{ translate('scan_barcode_to_start_work_on_sample') }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
         * Handle barcode scan for receipt
         */
        document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const barcode = this.value.trim();
                if (!barcode) return;

                handleBarcodeScan(barcode, 'receive');
            }
        });

        /**
         * Handle barcode scan for start work
         */
        document.getElementById('barcodeInputStartWork').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const barcode = this.value.trim();
                if (!barcode) return;

                handleBarcodeScan(barcode, 'start-work');
            }
        });

        /**
         * Handle barcode scan
         */
        function handleBarcodeScan(barcode, action) {
            const resultDiv = document.getElementById('result');
            const route = action === 'receive' 
                ? "{{ route('admin.submission.schedule.barcode.receive') }}"
                : "{{ route('admin.submission.schedule.barcode.start-work') }}";

            resultDiv.innerHTML = '<div class="alert alert-info">Processing...</div>';

            fetch(route, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ barcode: barcode })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = `<div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> ${data.message}
                    </div>`;
                } else {
                    resultDiv.innerHTML = `<div class="alert alert-danger">
                        <i class="fa fa-exclamation-circle"></i> ${data.message}
                    </div>`;
                }
                
                // Clear input and refocus
                if (action === 'receive') {
                    document.getElementById('barcodeInput').value = "";
                    document.getElementById('barcodeInput').focus();
                } else {
                    document.getElementById('barcodeInputStartWork').value = "";
                    document.getElementById('barcodeInputStartWork').focus();
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `<div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> {{ translate('error_occurred') }}
                </div>`;
                console.error('Error:', error);
            });
        }
    </script>
@endsection
