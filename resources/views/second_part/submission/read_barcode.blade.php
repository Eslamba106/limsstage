@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h3>{{ translate('read_barcode') }}</h3>
    <input type="text" id="barcodeInput" class="form-control" autofocus placeholder="{{ translate('Scan_the_barcode_here')}}">

    <div id="result" class="mt-3"></div>
</div>

<script>
document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        let barcode = this.value.trim();
        if (!barcode) return;

        fetch("{{ route('barcode.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ barcode: barcode })
        })
        .then(res => res.json())
        .then(data => {
            let resultDiv = document.getElementById('result');
            if (data.success) {
                resultDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
            document.getElementById('barcodeInput').value = "";
            document.getElementById('barcodeInput').focus();
        });
    }
});
</script>
@endsection
