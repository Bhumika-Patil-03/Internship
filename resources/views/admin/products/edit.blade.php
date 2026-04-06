@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="font-weight-bold mb-4">Edit Product: {{ $product->name }}</h4>

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Category</label>
                            <select name="category_id" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Price (₹)</label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>

                        <div class="form-group mb-4">
                            <label>Update Image (Leave blank to keep current)</label>
                            <input type="file" name="image" class="form-control-file d-block">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">UPDATE PRODUCT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection