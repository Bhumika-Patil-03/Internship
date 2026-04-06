@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-weight-bold text-uppercase" style="font-size: 1.1rem;">Update Category</h4>
                        <a href="{{ url('/admin/categories') }}" class="text-muted small">Cancel</a>
                    </div>

                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label class="font-weight-bold small text-muted text-uppercase">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="font-weight-bold small text-muted text-uppercase">Parent Category</label>
                            <select name="parent_id" class="form-control">
                                <option value="">None (Main Category)</option>
                                @foreach($categories as $parent)
                                    @if($parent->id != $category->id) <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <hr class="my-4">

                        <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm">
                            UPDATE CATEGORY
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection