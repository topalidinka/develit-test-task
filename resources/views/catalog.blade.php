@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Catalog</div>
                <div class="card-body">
                    <h4>Flowers</h4>
                    <table>
                        <thead>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <form action="/checkout/product/{{ $product->id }}" method="GET">
                                            <input type="number" name="quantity" id="quantity" value="1" min="1">
                                            <input type="submit" value="Buy">
                                        </form>
                                    </td>
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
