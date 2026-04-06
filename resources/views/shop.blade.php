@extends('layouts.frontend')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="https://images.unsplash.com/photo-1557821552-17105176677c?auto=format&fit=crop&w=1200&q=80">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{ $category->name ?? 'Shop' }}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ url('/') }}">Home</a>
                        <span>{{ $category->name ?? 'All Products' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="sidebar">
                    <div class="sidebar__item">
                        <h4>Categories</h4>
                        <ul>
                            @foreach($categories as $cat)
                                <li>
                                    <a href="{{ route('category.view', $cat->id) }}" 
                                       class="{{ isset($category) && $category->id == $cat->id ? 'text-primary font-weight-bold' : '' }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="sidebar__item">
                        <h4>Price Filter</h4>
                        <div class="price-range-wrap">
                            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                data-min="10" data-max="100000">
                                <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                <span class="ui-slider-handle ui-state-default ui-corner-all"></span>
                                <span class="ui-slider-handle ui-state-default ui-corner-all"></span>
                            </div>
                            <div class="range-slider">
                                <div class="price-input">
                                    <input type="text" id="minamount">
                                    <input type="text" id="maxamount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-9 col-md-7">
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="0">Price: Low to High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{ $products->count() }}</span> Products found</h6>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    @forelse($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{ asset($product->image) }}">
                                <ul class="product__item__pic__hover">
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
                            <div class="product__item__text text-center">
                                <h6><a href="{{ route('product.details', $product->id) }}">{{ $product->name }}</a></h6>
                                <h5 class="text-dark">₹ {{ number_format($product->price, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-lg-12 text-center py-5">
                        <p>No products found in this category.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection