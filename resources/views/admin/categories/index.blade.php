@extends('master')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 uppercase tracking-tight">Category Management</h2>
            <p class="text-gray-500 mt-1 italic text-sm">Review, Update, or Remove your categories and subcategories.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition duration-200">
            + Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-md shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs font-bold tracking-widest">
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Category Name</th>
                    <th class="px-6 py-4">Parent Category</th>
                    <th class="px-6 py-4">Created Date</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 font-mono text-gray-400 text-sm">#{{ $category->id }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-indigo-900 text-lg">{{ $category->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($category->parent)
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-medium border border-indigo-100">
                                Subcategory of: {{ $category->parent->name }}
                            </span>
                        @else
                            <span class="text-gray-400 italic text-sm italic">Main Category</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $category->created_at->format('d M, Y') }}</td>
                    
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center space-x-6">
                            <a href="{{ route('categories.edit', $category->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Warning: Deleting a category will affect related products. Continue?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                        No categories found. Click "+ Add New Category" to start.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection