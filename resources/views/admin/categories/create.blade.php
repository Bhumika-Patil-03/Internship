@extends('master')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase">Add New Category</h2>

    <form id="categoryForm" action="{{ route('categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
            <input type="text" id="catName" name="name" value="{{ old('name') }}" 
                class="mt-1 block w-full border border-gray-300 rounded-md p-3 shadow-sm focus:ring-indigo-500">
            @error('name')
                <p class="text-red-500 text-sm mt-2 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Parent Category (Optional)</label>
            <select name="parent_id" class="mt-1 block w-full border border-gray-300 rounded-md p-3 shadow-sm">
                <option value="">None (Main Category)</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4">
            <a href="{{ route('categories.index') }}" class="text-gray-400 font-bold text-sm">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-md font-bold hover:bg-indigo-700 shadow-md">
                Save Category
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('categoryForm').onsubmit = function(e) {
        const name = document.getElementById('catName').value.trim();
        if (name === "") {
            e.preventDefault(); // Stop form from sending
            alert("Error: Category Name is a compulsory field!");
        }
    };
</script>
@endsection