@extends('layouts.frontend')

@section('content')
<div class="container mt-5 mb-5">
    <div class="section-title">
        <h2>My Purchase History</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="shopping__cart__table">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td class="font-weight-bold">{{ $order->product_name }}</td>
                            <td>₹{{ number_format($order->price, 2) }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $order->status == 'pending' ? 'badge-warning' : '' }}
                                    {{ $order->status == 'cancelled' ? 'badge-danger' : '' }}
                                    {{ $order->status == 'delivered' ? 'badge-success' : '' }}">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </td>
                            <td>
                                @if($order->status == 'pending')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this order?')">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">No actions</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <h5>You haven't ordered anything yet.</h5>
                                <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Shopping</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection