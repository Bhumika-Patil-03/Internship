@extends('master')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    
    <div class="flex space-x-4 mb-10 border-b border-gray-100 pb-6">
        <button onclick="showSection('categorySection')" id="btnCategory" 
            class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition duration-200 uppercase tracking-wider text-xs">
            Manage Categories
        </button>
        <button onclick="showSection('userSection')" id="btnUser" 
            class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-bold hover:bg-gray-300 transition duration-200 uppercase tracking-wider text-xs">
            View Users
        </button>
    </div>

    <div id="categorySection" class="section-content">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 uppercase">Category Details</h2>
            <a href="{{ route('categories.create') }}" class="text-indigo-600 font-bold hover:underline text-sm">+ Add New</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs font-bold">
                        <th class="px-6 py-4">Category Name (Click to view products)</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold">
                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}" 
                               class="text-indigo-600 hover:text-indigo-800 hover:underline decoration-2 transition">
                                {{ $category->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $category->parent_id ? 'Subcategory' : 'Main Category' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-4">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 font-bold text-sm hover:underline">Edit</a>
                                
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Deleting this category will affect related products. Continue?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 font-bold text-sm uppercase hover:text-red-700">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="userSection" class="section-content hidden">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 uppercase">System Users</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs font-bold">
                        <th class="px-6 py-4">User Name</th>
                        <th class="px-6 py-4">Email Address</th>
                        <th class="px-6 py-4">Role Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->is_admin)
                                <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">Admin</span>
                            @else
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-[10px] font-black uppercase">User</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
function showSection(sectionId) {
    document.querySelectorAll('.section-content').forEach(section => {
        section.classList.add('hidden');
    });
    document.getElementById(sectionId).classList.remove('hidden');

    const btnCat = document.getElementById('btnCategory');
    const btnUsr = document.getElementById('btnUser');

    if(sectionId === 'categorySection') {
        btnCat.className = "bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold shadow-md uppercase text-xs";
        btnUsr.className = "bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-bold hover:bg-gray-300 uppercase text-xs";
    } else {
        btnUsr.className = "bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold shadow-md uppercase text-xs";
        btnCat.className = "bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-bold hover:bg-gray-300 uppercase text-xs";
    }
}
</script>
@endsection