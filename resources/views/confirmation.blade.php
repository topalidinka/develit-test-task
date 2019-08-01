@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Confirmation</div>

                <div class="card-body">
                    <h3 style="text-align:center;">Checkout ID: {{ $paysonCheckout['id'] }}</h3><hr />
                    {!! $paysonCheckout['snippet'] !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
