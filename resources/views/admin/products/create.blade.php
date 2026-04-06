@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow border-0 col-md-8 mx-auto p-4">
        <h3 class="text-center font-weight-bold mb-4">Add New Product</h3>
        
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group mb-3">
                <label class="font-weight-bold">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Select --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">Price (₹)</label>
                    <input type="number" name="price" class="form-control" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="font-weight-bold">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold">Product Image</label>
                <input type="file" name="image" class="form-control-file" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold">SAVE PRODUCT</button>
        </form>
    </div>
</div>
@endsection