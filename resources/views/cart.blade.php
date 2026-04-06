@extends('layouts.frontend')

@section('content')
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cartItems as $item)
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="{{ asset($item->product->image) }}" alt="" style="width: 100px;">
                                    <h5>{{ $item->product->name }}</h5>
                                </td>
                                <td class="shoping__cart__price">₹{{ number_format($item->product->price, 2) }}</td>
                                <td class="shoping__cart__quantity">{{ $item->quantity }}</td>
                                <td class="shoping__cart__total">₹{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td class="shoping__cart__item__close">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="border:none; background:none;"><span class="icon_close"></span></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection