@extends('master')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase">Update Category</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Category Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required 
                class="mt-1 block w-full border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md p-3 shadow-sm">
            
            @error('name')
                <p class="text-red-500 text-sm mt-2 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700">Parent Category</label>
            <select name="parent_id" class="mt-1 block w-full border border-gray-300 rounded-md p-3 shadow-sm">
                <option value="">None (Main Category)</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <a href="{{ route('categories.index') }}" class="text-gray-400 font-bold text-sm">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-md font-bold hover:bg-indigo-700 shadow-lg">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection