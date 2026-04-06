@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex mb-4 justify-content-between align-items-center">
        <div>
            <a href="{{ url('/admin/categories') }}" class="btn {{ request()->is('*categories*') || request()->is('dashboard') ? 'btn-primary text-white' : 'btn-light border' }} mr-2 shadow-sm">
                CATEGORIES
            </a>
            <a href="{{ url('/admin/products') }}" class="btn {{ request()->is('*products*') ? 'btn-primary text-white' : 'btn-light border' }} mr-2 shadow-sm">
                PRODUCTS
            </a>
            <a href="{{ url('/admin/users') }}" class="btn {{ request()->is('*users*') ? 'btn-primary text-white' : 'btn-light border' }} mr-2 shadow-sm">
                USERS
            </a>
            <a href="{{ url('/admin/orders') }}" class="btn {{ request()->is('*orders*') ? 'btn-primary text-white' : 'btn-light border' }} shadow-sm">
                ORDERS
            </a>
        </div>
        <a href="{{ url('/') }}" class="btn btn-outline-primary shadow-sm">
            <i class="fa fa-home"></i> VIEW STORE
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-weight-bold text-uppercase" style="font-size: 1.1rem;">
                    @if(request()->is('*orders*')) Recent Orders 
                    @elseif(request()->is('*products*')) Product List 
                    @elseif(request()->is('*users*')) Registered Users 
                    @else Category List @endif
                </h4>

                @if(request()->is('*products*'))
                    <a href="{{ route('products.create') }}" class="text-primary font-weight-bold" style="text-decoration:none;">+ Add New Product</a>
                @elseif(request()->is('*categories*') || request()->is('dashboard'))
                    <a href="{{ route('categories.create') }}" class="text-primary font-weight-bold" style="text-decoration:none;">+ Add New Category</a>
                @endif
            </div>

            <table class="table table-hover">
                <thead class="bg-light">
                    <tr class="text-secondary small text-uppercase font-weight-bold">
                        @if(request()->is('*orders*'))
                            <th>Order ID</th><th>Customer</th><th>Product</th><th>Price</th><th>Status</th><th class="text-right">Action</th>
                        @elseif(request()->is('*products*'))
                            <th>Name</th><th>Price</th><th>Category</th><th>Created At</th><th class="text-right">Action</th>
                        @elseif(request()->is('*users*'))
                            <th>ID</th><th>Name</th><th>Email</th><th>Role</th>
                        @else
                            <th>Category Name</th><th>Type</th><th>Created At</th><th class="text-right">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(request()->is('*orders*'))
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td class="font-weight-bold">{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ $order->product_name }}</td>
                            <td>₹ {{ number_format($order->price, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->status == 'pending' ? 'badge-warning' : 'badge-success' }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                            <td class="text-right">
                                @if($order->status == 'pending')
                                <form action="{{ route('order.update', [$order->id, 'completed']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-sm btn-success shadow-sm">Complete</button>
                                </form>
                                @else
                                <span class="text-muted small">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4">No orders received yet.</td></tr>
                        @endforelse

                    @elseif(request()->is('*products*'))
                        @forelse($products as $product)
                        <tr>
                            <td class="text-primary font-weight-bold">{{ $product->name }}</td>
                            <td>₹ {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>{{ $product->created_at->format('d M, Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-primary mr-2">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="text-danger border-0 bg-transparent p-0" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4">No products found.</td></tr>
                        @endforelse

                    @elseif(request()->is('*users*'))
                        @foreach($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->is_admin ? 'badge-danger' : 'badge-success' }}">
                                    {{ $user->is_admin ? 'ADMIN' : 'USER' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach

                    @else
                        @foreach($categories as $category)
                        <tr>
                            <td class="text-primary font-weight-bold">{{ $category->name }}</td>
                            <td>{{ $category->parent_id ? 'Sub' : 'Main' }}</td>
                            <td>{{ $category->created_at->format('d M, Y') }}</td>
                            <td class="text-right">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-primary mr-2">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="text-danger border-0 bg-transparent p-0" onclick="return confirm('Delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection