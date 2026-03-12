@extends('master')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase tracking-tight">Update Product</h2>

    <form id="editProductForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                <input type="text" id="pName" name="name" value="{{ old('name', $product->name) }}" 
                    class="w-full border border-gray-300 rounded-lg p-3 outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Main Category <span class="text-red-500">*</span></label>
                    <select id="main_category" name="category_id" class="w-full border border-gray-300 rounded-lg p-3 outline-none">
                        @foreach($categories->whereNull('parent_id') as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Subcategory</label>
                    <select id="subcategory" name="subcategory_id" class="w-full border border-gray-300 rounded-lg p-3 outline-none">
                        <option value="">Select Subcategory</option>
                        @if($product->subcategory_id)
                             @php 
                                $subs = \App\Models\Category::where('parent_id', $product->category_id)->get(); 
                             @endphp
                             @foreach($subs as $sub)
                                <option value="{{ $sub->id }}" {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->name }}
                                </option>
                             @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Price (₹) <span class="text-red-500">*</span></label>
                    <input type="number" id="pPrice" name="price" value="{{ old('price', $product->price) }}" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Update Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded-lg p-2 bg-gray-50 text-sm">
                    @if($product->image)
                        <p class="text-xs text-gray-500 mt-1 italic italic">Current image exists</p>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg p-3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <a href="{{ route('products.index') }}" class="text-gray-400 font-bold text-sm">← Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition">
                    Update Product
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('main_category').addEventListener('change', function() {
        const parentId = this.value;
        const subSelect = document.getElementById('subcategory');
        
        subSelect.innerHTML = '<option value="">Loading...</option>';

        if (parentId) {
            fetch(`/get-subcategories/${parentId}`)
                .then(response => response.json())
                .then(data => {
                    subSelect.innerHTML = '<option value="">Select Subcategory</option>';
                    data.forEach(sub => {
                        subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                    });
                });
        } else {
            subSelect.innerHTML = '<option value="">Select Main First</option>';
        }
    });

    // Mandatory Field Popup
    document.getElementById('editProductForm').onsubmit = function(e) {
        if (!document.getElementById('pName').value.trim() || !document.getElementById('main_category').value || !document.getElementById('pPrice').value) {
            e.preventDefault();
            alert("Compulsory fields (Name, Category, Price) cannot be empty!");
        }
    };
</script>
@endsection