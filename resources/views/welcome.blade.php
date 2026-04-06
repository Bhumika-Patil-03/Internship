@extends('layouts.frontend')

@section('content')
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Categories</span>
                    </div>
                    <ul>
                        @foreach($categories as $category)
                            <li><a href="{{ route('category.view', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form w-100">
                        <form action="{{ url('/') }}" method="GET">
                            <input type="text" name="search" placeholder="What do you need?" value="{{ request('search') }}">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                        </div>
                </div>
                
                @auth
                <div class="hero__item set-bg shadow-sm rounded" data-setbg="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80">
                    <div class="hero__text">
                        @if(Auth::user()->is_admin == 1)
                            <span class="text-white-50">ADMIN PORTAL</span>
                            <h2 class="text-white">Manage Store <br />Operations</h2>
                            <a href="{{ url('/dashboard') }}" class="primary-btn">GO TO DASHBOARD</a>
                        @else
                            <span class="text-white-50">WELCOME BACK</span>
                            <h2 class="text-white">Premium <br />Electronics</h2>
                            <a href="{{ route('shop.index') }}" class="primary-btn">SHOP NOW</a>
                        @endif
                    </div>
                </div>
                @else
                <div class="hero__item set-bg shadow-sm rounded" data-setbg="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=1200&q=80">
                    <div class="hero__text">
                        <span>TECHSTORE</span>
                        <h2>New Tech <br />Arrivals</h2>
                        <a href="/register" class="primary-btn">JOIN NOW</a>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>

<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <h2>
                        @if(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            Featured Products
                        @endif
                    </h2>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="featured__item">
                    <div class="featured__item__pic set-bg" data-setbg="{{ asset($product->image) }}">
                        <ul class="featured__item__pic__hover">
                            <li>
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="border:none; background:none; padding:0;">
                                        <a><i class="fa fa-heart"></i></a>
                                    </button>
                                </form>
                            </li>
                            <li><a href="{{ route('product.details', $product->id) }}"><i class="fa fa-info"></i></a></li>
                            <li>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="border:none; background:none; padding:0;">
                                        <a><i class="fa fa-shopping-cart"></i></a>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="featured__item__text">
                        <h6><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h6>
                        <h5>₹{{ number_format($product->price, 2) }}</h5>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <h4>No products found matching "{{ request('search') }}".</h4>
                <a href="{{ url('/') }}" class="text-primary">Clear Search</a>
            </div>
            @endforelse
        </div>
    </div>
</section>

<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @foreach($latestProducts->chunk(3) as $chunk)
                        <div class="latest-prduct__slider__item">
                            @foreach($chunk as $lp)
                            <a href="{{ route('product.details', $lp->id) }}" class="latest-product__item d-flex align-items-center mb-3">
                                <div class="latest-product__item__pic mr-3" style="width: 100px;">
                                    <img src="{{ asset($lp->image) }}" class="img-fluid border rounded">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>{{ $lp->name }}</h6>
                                    <span>₹{{ number_format($lp->price) }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Rated</h4>
                    <div class="latest-product__slider owl-carousel">
                        @foreach($topRatedProducts->chunk(3) as $chunk)
                        <div class="latest-prduct__slider__item">
                            @foreach($chunk as $tp)
                            <a href="{{ route('product.details', $tp->id) }}" class="latest-product__item d-flex align-items-center mb-3">
                                <div class="latest-product__item__pic mr-3" style="width: 100px;">
                                    <img src="{{ asset($tp->image) }}" class="img-fluid border rounded">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>{{ $tp->name }}</h6>
                                    <span>₹{{ number_format($tp->price) }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Review Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @foreach($reviewProducts->chunk(3) as $chunk)
                        <div class="latest-prduct__slider__item">
                            @foreach($chunk as $rp)
                            <a href="{{ route('product.details', $rp->id) }}" class="latest-product__item d-flex align-items-center mb-3">
                                <div class="latest-product__item__pic mr-3" style="width: 100px;">
                                    <img src="{{ asset($rp->image) }}" class="img-fluid border rounded">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>{{ $rp->name }}</h6>
                                    <span>₹{{ number_format($rp->price) }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection