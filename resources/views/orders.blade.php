@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Orders</div>
                <div class="card-body">
                    <table>
                        <thead>
                            <th>Checkout Id</th>
                            <th>Count</th>
                            <th>User</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->checkout_id }}</td>
                                    <td>{{ $order->count }}</td>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
