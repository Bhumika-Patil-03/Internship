@extends('layouts.frontend')

@section('content')
<section class="shoping-cart spad">
    <div class="container">
        <div class="section-title"><h2>My Wishlist</h2></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wishlistItems as $item)
                            <tr>
                                <td class="shoping__cart__item">
                                    <img src="{{ asset($item->product->image) }}" alt="" style="width: 100px;">
                                    <h5>{{ $item->product->name }}</h5>
                                </td>
                                <td class="shoping__cart__price">₹{{ number_format($item->product->price, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.add', $item->product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                                    </form>
                                    <form action="{{ route('wishlist.toggle', $item->product->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">Your wishlist is empty.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection