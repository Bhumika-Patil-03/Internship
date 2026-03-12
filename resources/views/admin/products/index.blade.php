@extends('master')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 uppercase">Product Inventory</h2>
            <p class="text-gray-500 mt-1 italic text-sm">Review your products and their categories.</p>
        </div>
        <a href="{{ route('products.create') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-bold shadow-md hover:bg-emerald-700 transition">
            + Add New Product
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Search by product name..." value="{{ request('search') }}" class="border border-gray-300 rounded-lg p-2 w-full max-w-sm outline-none focus:ring-2 focus:ring-emerald-500">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-bold">Search</button>
            @if(request('category_id') || request('search'))
                <a href="{{ route('products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold flex items-center">Clear</a>
            @endif
        </form>
    </div>

    @if(request('category_id'))
        <div class="mb-4 p-3 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100 text-sm font-medium">
            Filtering by Category ID: {{ request('category_id') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs font-bold tracking-widest">
                    <th class="px-6 py-4">Image</th>
                    <th class="px-6 py-4">Product Name</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Price</th>
                    <th class="px-6 py-4">Created Date</th> <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded shadow-sm object-cover border border-gray-100">
                        @else
                            <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-[10px] text-gray-400 italic">No Image</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-indigo-600 font-medium">
                        {{ $product->category->name ?? 'N/A' }}
                        <div class="text-[10px] text-gray-400 font-normal">
                            {{ $product->subcategory->name ?? '' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono text-emerald-600 font-bold">₹{{ number_format($product->price, 2) }}</td>
                    
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $product->created_at->format('d M, Y') }}
                    </td>

                    <td class="px-6 py-4 text-center space-x-4">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-indigo-600 font-bold text-sm hover:underline">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 font-bold text-sm uppercase">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">No products available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->appends(request()->input())->links() }}
    </div>
</div>
@endsection