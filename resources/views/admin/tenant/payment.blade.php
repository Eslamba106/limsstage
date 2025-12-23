@extends('front_office_layouts.main')
@section('title', translate('register_tenant'))
@section('content')
    <!-- Newsletter Start -->
 
    <form accept-charset="UTF-8" action="https://api.moyasar.com/v1/payments.html" method="POST">
        <div class="container-fluid py-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card shadow-lg" style="width: 450px; max-width: 100%;">
                <div class="card-body">
                    <input type="hidden" name="callback_url" value="{{ url(route('payment.callback', [$schema->id , 'tenant_id'=> $tenant->id])) }}" />
                    <input type="hidden" name="publishable_api_key" value="{{ config('services.moyasar.key') }}" />
                    <input type="hidden" name="amount" value="{{ $schema->price }}" />
                    <input type="hidden" name="tenant_id" value="{{ $tenant->id }}" />
                    <input type="hidden" name="source[type]" value="creditcard" />
                    <input type="hidden" name="description" value="Schema id {{ $schema->id }}   " />

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Card Holder" name="source[name]" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Card Number" name="source[number]" />
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Expiry Month" name="source[month]" />
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="Expiry Year" name="source[year]" />
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" placeholder="CVC" name="source[cvc]" />
                    </div>

                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
            </div>
        </div>

    </form>

@endsection
