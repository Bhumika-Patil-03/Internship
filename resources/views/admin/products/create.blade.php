@extends('master')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 uppercase tracking-tight">Add New Product</h2>

    <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Product Name <span class="text-red-500">*</span></label>
                <input type="text" id="pName" name="name" class="w-full border border-gray-300 rounded-lg p-3 outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select id="main_category" name="category_id" class="w-full border border-gray-300 rounded-lg p-3 outline-none">
                        <option value="">Select Category</option>
                        @foreach($categories->whereNull('parent_id') as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Subcategory</label>
                    <select id="subcategory" name="subcategory_id" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 outline-none" disabled>
                        <option value="">Select Category First</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Price (₹) <span class="text-red-500">*</span></label>
                    <input type="number" id="pPrice" name="price" class="w-full border border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded-lg p-2 bg-gray-50 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg p-3"></textarea>
            </div>

            <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-lg font-bold shadow-lg hover:bg-emerald-700">Save Product</button>
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
                .then(res => res.json())
                .then(data => {
                    subSelect.innerHTML = '<option value="">Select Subcategory</option>';
                    data.forEach(sub => { subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`; });
                    subSelect.disabled = false;
                    subSelect.classList.remove('bg-gray-50');
                });
        } else {
            subSelect.innerHTML = '<option value="">Select Category First</option>';
            subSelect.disabled = true;
        }
    });

    document.getElementById('productForm').onsubmit = function(e) {
        if (!document.getElementById('pName').value.trim() || !document.getElementById('main_category').value || !document.getElementById('pPrice').value) {
            e.preventDefault();
            alert("Compulsory fields: Name, Category, and Price must be filled!");
        }
    };
</script>
@endsection