@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Checkout</div>

                <p>
                  Test card: 4581 1111 1111 1112
                </p>

                <div id="wrapper" style="width:100%;max-width:600px;margin:0 auto;">

                    <h3 style="text-align:center;">Checkout ID: {{ $paysonCheckout['id'] }}</h3>
                    <hr/>

                    {!! $paysonCheckout['snippet'] !!}

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

