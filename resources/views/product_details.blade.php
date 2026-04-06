@extends('layouts.frontend')

@section('content')
<section class="breadcrumb-section set-bg shadow-sm mb-5" data-setbg="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=1200&q=80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text p-5">
                    <h2 class="text-white font-weight-bold">{{ $product->name }}</h2>
                    <div class="breadcrumb__option text-white-50">
                        <a href="{{ url('/') }}" class="text-white">Home</a>
                        <span>{{ $product->category->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product__details__pic border rounded shadow-sm p-4 bg-white text-center">
                    @php $imgUrl = !empty($product->image) ? asset($product->image) : 'https://via.placeholder.com/500'; @endphp
                    <img class="img-fluid" src="{{ $imgUrl }}" alt="{{ $product->name }}" style="max-height: 450px; object-fit: contain;">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product__details__text">
                    <h3 class="font-weight-bold text-dark mb-2">{{ $product->name }}</h3>
                    <div class="product__details__price text-primary h2 font-weight-bold mb-4">₹{{ number_format($product->price, 2) }}</div>
                    <p class="text-muted">{{ $product->description ?? 'Premium electronic gadget from TechStore.' }}</p>
                    
                    <hr class="my-4">

                    <div class="product__details__quantity mt-4">
                        @guest
                            <a href="{{ route('login') }}" class="primary-btn shadow-sm btn-block text-center">
                                <i class="fa fa-user mr-2"></i> LOGIN TO PURCHASE
                            </a>
                        @else
                            @if(Auth::user()->is_admin == 1)
                                <div class="p-3 bg-light border rounded text-center">
                                    <p class="small text-muted mb-2">You are viewing this as an <b>Admin</b>.</p>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm px-4">
                                        <i class="fa fa-edit mr-1"></i> EDIT THIS PRODUCT
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('product.buy', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="primary-btn shadow-sm border-0 py-3 px-5 font-weight-bold text-uppercase w-100">
                                        <i class="fa fa-shopping-bag mr-2"></i> BUY NOW (CASH ON DELIVERY)
                                    </button>
                                </form>
                                <p class="small text-center text-success font-weight-bold mt-2">
                                    <i class="fa fa-truck mr-1"></i> Free Shipping for Customers
                                </p>
                            @endif
                        @endguest
                    </div>

                    <ul class="mt-5 border-top pt-4 list-unstyled small text-uppercase font-weight-bold text-muted">
                        <li class="mb-2"><b>Availability:</b> <span class="text-success ml-2">In Stock</span></li>
                        <li class="mb-2"><b>Category:</b> <span class="ml-2 text-primary">{{ $product->category->name }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection